/**
 * National Admin PDF export.
 * Uses html2canvas + jsPDF directly (html2pdf.bundle does not expose either global).
 *
 * Pagination strategy: rather than screenshotting the whole page into one tall
 * canvas and slicing it by pixel count (which can cut straight through a
 * chart), each visual "block" (filters panel, metric-card row, a row of
 * chart-cards, a standalone panel like a heatmap/map) is captured as its own
 * image. Blocks are then packed onto PDF pages, starting a new page whenever
 * the next block would not fit in the remaining space. A block is only ever
 * pixel-sliced across pages if it is, by itself, taller than a full page.
 */
(function () {
    'use strict';

    var EXPORTING = false;
    var CAPTURE_WIDTH = 1280;
    var MAX_CANVAS = 8192;
    var A3_W = 420;
    var A3_H = 297;
    var MARGIN = 10;
    var BLOCK_GAP_MM = 4;

    function wait(ms) {
        return new Promise(function (resolve) { setTimeout(resolve, ms); });
    }

    function nextFrame() {
        return new Promise(function (resolve) {
            requestAnimationFrame(function () { requestAnimationFrame(resolve); });
        });
    }

    function defaultFilename() {
        var path = (window.location.pathname || '').toLowerCase();
        if (path.indexOf('heatmap') !== -1) return 'national-admin-heatmap.pdf';
        if (path.indexOf('reports') !== -1) return 'national-admin-reports.pdf';
        return 'National-admin-dashboard.pdf';
    }

    function getHtml2Canvas() {
        if (typeof window.html2canvas === 'function') return window.html2canvas;
        throw new Error('html2canvas failed to load');
    }

    function getJsPDF() {
        if (window.jspdf && window.jspdf.jsPDF) return window.jspdf.jsPDF;
        if (window.jsPDF) return window.jsPDF;
        throw new Error('jsPDF failed to load');
    }

    function ensureOverlay() {
        var el = document.getElementById('na-pdf-overlay');
        if (el) return el;
        el = document.createElement('div');
        el.id = 'na-pdf-overlay';
        el.setAttribute('role', 'status');
        el.setAttribute('aria-live', 'polite');
        el.innerHTML = '<div class="na-pdf-overlay-card">'
            + '<strong>Preparing PDF</strong>'
            + '<span>Capturing the page at full quality\u2026</span>'
            + '</div>';
        document.body.appendChild(el);
        return el;
    }

    function setOverlay(visible, label) {
        var el = ensureOverlay();
        if (label) {
            var span = el.querySelector('span');
            if (span) span.textContent = label;
        }
        el.classList.toggle('is-visible', !!visible);
        document.body.classList.toggle('na-pdf-busy', !!visible);
    }

    function closeChrome() {
        document.querySelectorAll('.modal-backdrop.active, .modal-backdrop[aria-hidden="false"]').forEach(function (m) {
            m.classList.remove('active');
            m.setAttribute('aria-hidden', 'true');
            if (m.style && m.style.display === 'flex') m.style.display = 'none';
        });
        var reportModal = document.getElementById('reportModal');
        if (reportModal) {
            reportModal.style.display = 'none';
            reportModal.setAttribute('aria-hidden', 'true');
        }
        if (typeof window.toggleSidebar === 'function') {
            var sidebar = document.getElementById('na-sidebar');
            if (sidebar && sidebar.classList.contains('open')) window.toggleSidebar();
        }
    }

    function resizeCharts(root) {
        if (typeof Chart === 'undefined' || typeof Chart.getChart !== 'function') return;
        root.querySelectorAll('canvas').forEach(function (canvas) {
            var chart = Chart.getChart(canvas);
            if (chart && typeof chart.resize === 'function') chart.resize();
        });
    }

    function snapshotCanvases(root) {
        var snaps = [];
        root.querySelectorAll('canvas').forEach(function (canvas) {
            if (canvas.closest('.na-pdf-hide')) return;
            if ((canvas.clientWidth || canvas.width) < 4) return;
            try {
                var img = document.createElement('img');
                img.className = 'na-pdf-canvas-snapshot';
                img.alt = canvas.getAttribute('aria-label') || 'Chart';
                img.src = canvas.toDataURL('image/png');
                var w = canvas.clientWidth || canvas.width;
                var h = canvas.clientHeight || canvas.height;
                img.style.width = w + 'px';
                img.style.height = h + 'px';
                img.style.display = 'block';
                img.style.maxWidth = '100%';
                canvas.style.display = 'none';
                canvas.parentNode.insertBefore(img, canvas);
                snaps.push({ canvas: canvas, img: img });
            } catch (err) { /* leave original */ }
        });
        return snaps;
    }

    function snapshotMapSvg(root) {
        var snaps = [];
        root.querySelectorAll('.district-map-svg, svg.district-map-svg').forEach(function (svg) {
            try {
                var box = svg.getBoundingClientRect();
                var w = Math.max(1, Math.round(box.width || svg.clientWidth || 800));
                var h = Math.max(1, Math.round(box.height || svg.clientHeight || 520));
                var clone = svg.cloneNode(true);
                clone.setAttribute('width', String(w));
                clone.setAttribute('height', String(h));
                clone.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                var xml = new XMLSerializer().serializeToString(clone);
                var img = document.createElement('img');
                img.className = 'na-pdf-svg-snapshot';
                img.alt = 'Map';
                img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(xml);
                img.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:contain;display:block;';
                svg.style.display = 'none';
                svg.parentNode.insertBefore(img, svg);
                snaps.push({ svg: svg, img: img });
            } catch (err) { /* leave original */ }
        });
        return snaps;
    }

    function restoreSnapshots(snaps) {
        (snaps || []).forEach(function (item) {
            if (item.canvas) item.canvas.style.display = '';
            if (item.svg) item.svg.style.display = '';
            if (item.img && item.img.parentNode) item.img.parentNode.removeChild(item.img);
        });
    }

    function waitForSnapshots(snaps) {
        return Promise.all((snaps || []).map(function (item) {
            var img = item && item.img;
            if (!img || img.complete) return Promise.resolve();
            return new Promise(function (resolve) {
                img.onload = resolve;
                img.onerror = resolve;
            });
        }));
    }

    // Off-screen clone laid out at a fixed width so what we measure for
    // block/row boundaries is exactly what html2canvas renders — no more
    // "virtual window width" mismatch between measurement and capture.
    function buildCaptureHost(source) {
        var existing = document.getElementById('na-pdf-capture-host');
        if (existing && existing.parentNode) existing.parentNode.removeChild(existing);

        var host = document.createElement('div');
        host.id = 'na-pdf-capture-host';
        host.style.position = 'absolute';
        host.style.left = '-99999px';
        host.style.top = '0';
        host.style.background = '#ffffff';

        var clone = source.cloneNode(true);
        clone.removeAttribute('id');
        clone.style.width = CAPTURE_WIDTH + 'px';
        clone.style.maxWidth = 'none';
        clone.style.minWidth = '0';
        clone.style.height = 'auto';
        clone.style.overflow = 'visible';
        clone.style.margin = '0';
        host.appendChild(clone);
        document.body.appendChild(host);
        return host;
    }

    function pickScale(width, height) {
        var scale = 2;
        if (width * scale > MAX_CANVAS) scale = MAX_CANVAS / width;
        if (height * scale > MAX_CANVAS) scale = Math.min(scale, MAX_CANVAS / height);
        return Math.max(1, Math.round(scale * 100) / 100);
    }

    // Group elements that visually share a row (e.g. side-by-side chart-cards
    // in a CSS grid) so they're captured — and therefore paginated — together.
    function clusterRows(elements) {
        var items = elements
            .filter(function (el) { return el.nodeType === 1; })
            .map(function (el) { return { el: el, rect: el.getBoundingClientRect() }; })
            .sort(function (a, b) { return a.rect.top - b.rect.top; });
        var rows = [];
        items.forEach(function (item) {
            var last = rows[rows.length - 1];
            if (last && item.rect.top < last.bottom - 2) {
                last.bottom = Math.max(last.bottom, item.rect.bottom);
                last.top = Math.min(last.top, item.rect.top);
            } else {
                rows.push({ top: item.rect.top, bottom: item.rect.bottom });
            }
        });
        return rows;
    }

    // Build an ordered list of capture blocks. Each block is either a whole
    // element ({kind:'element', el}) or a cropped rectangle within a parent
    // ({kind:'crop', ancestor, x, y, width, height}) — used for CSS-grid rows
    // where there's no single DOM node wrapping just that row.
    function buildBlocks(hostRoot) {
        var blocks = [];
        var scrollRoot = hostRoot.querySelector('.dashboard-scroll') || hostRoot;

        Array.prototype.forEach.call(scrollRoot.children, function (section) {
            if (!(section instanceof HTMLElement)) return;

            var grid = section.classList.contains('chart-grid')
                ? section
                : (section.querySelector ? section.querySelector('.chart-grid') : null);

            if (grid) {
                Array.prototype.forEach.call(section.children, function (child) {
                    if (child === grid || (child.classList && child.classList.contains('chart-grid'))) {
                        var rows = clusterRows(Array.prototype.slice.call(child.children));
                        var gridRect = child.getBoundingClientRect();
                        rows.forEach(function (row) {
                            blocks.push({
                                kind: 'crop',
                                ancestor: child,
                                x: 0,
                                y: row.top - gridRect.top,
                                width: gridRect.width,
                                height: row.bottom - row.top
                            });
                        });
                    } else {
                        blocks.push({ kind: 'element', el: child });
                    }
                });
                return;
            }

            blocks.push({ kind: 'element', el: section });
        });

        if (!blocks.length) {
            blocks.push({ kind: 'element', el: scrollRoot });
        }

        return blocks;
    }

    function captureBlock(block) {
        var html2canvas = getHtml2Canvas();

        if (block.kind === 'crop') {
            if (block.width < 2 || block.height < 2) return Promise.resolve(null);
            return html2canvas(block.ancestor, {
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                logging: false,
                scale: pickScale(block.width, block.height),
                x: block.x,
                y: block.y,
                width: block.width,
                height: block.height
            }).catch(function () { return null; });
        }

        var r = block.el.getBoundingClientRect();
        if (r.width < 2 || r.height < 2) return Promise.resolve(null);
        return html2canvas(block.el, {
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
            scale: pickScale(r.width, r.height)
        }).catch(function () { return null; });
    }

    function captureAllBlocks(blocks) {
        var canvases = [];
        return blocks.reduce(function (p, block) {
            return p.then(function () {
                return captureBlock(block).then(function (canvas) {
                    canvases.push(canvas);
                });
            });
        }, Promise.resolve()).then(function () { return canvases; });
    }

    function whiteBg(pdf) {
        pdf.setFillColor(255, 255, 255);
        pdf.rect(0, 0, A3_W, A3_H, 'F');
    }

    // Places one block's canvas onto the PDF, starting a new page if it
    // doesn't fit in the remaining space. Only pixel-slices across pages if
    // the block alone is taller than one full page (rare — e.g. a very long
    // table) — normal blocks are never split.
    function addBlockToPdf(pdf, canvas, cursor, usableW, usableH) {
        var imgHmm = (canvas.height / canvas.width) * usableW;

        if (imgHmm <= usableH) {
            if (cursor.y + imgHmm > MARGIN + usableH + 0.01) {
                pdf.addPage([A3_W, A3_H], 'landscape');
                whiteBg(pdf);
                cursor.y = MARGIN;
            }
            pdf.addImage(canvas, 'JPEG', MARGIN, cursor.y, usableW, imgHmm);
            cursor.y += imgHmm + BLOCK_GAP_MM;
            return;
        }

        // Oversized block: give it fresh pages of its own.
        if (cursor.y > MARGIN + 0.01) {
            pdf.addPage([A3_W, A3_H], 'landscape');
            whiteBg(pdf);
            cursor.y = MARGIN;
        }

        var imgW = canvas.width;
        var imgH = canvas.height;
        var pageHeightPx = Math.max(1, Math.floor(imgW * (usableH / usableW)));
        var y = 0;
        var first = true;

        while (y < imgH - 1) {
            if (!first) {
                pdf.addPage([A3_W, A3_H], 'landscape');
                whiteBg(pdf);
            }
            first = false;

            var split = Math.min(imgH, y + pageHeightPx);
            var sliceH = Math.max(1, split - y);
            var slice = document.createElement('canvas');
            slice.width = imgW;
            slice.height = sliceH;
            var ctx = slice.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, imgW, sliceH);
            ctx.drawImage(canvas, 0, y, imgW, sliceH, 0, 0, imgW, sliceH);

            var sliceMmH = (sliceH / imgW) * usableW;
            pdf.addImage(slice, 'JPEG', MARGIN, MARGIN, usableW, sliceMmH);
            y = split;
        }

        // Force the next block onto a fresh page rather than trying to
        // squeeze it under a partial last slice.
        cursor.y = MARGIN + usableH + 1;
    }

    function writePdfFromBlocks(canvases, filename) {
        var valid = canvases.filter(function (c) { return c && c.width && c.height; });
        if (!valid.length) throw new Error('Page capture was empty');

        var JsPDF = getJsPDF();
        var usableW = A3_W - MARGIN * 2;
        var usableH = A3_H - MARGIN * 2;
        var pdf = new JsPDF({ unit: 'mm', format: 'a3', orientation: 'landscape' });
        whiteBg(pdf);

        var cursor = { y: MARGIN };
        valid.forEach(function (canvas) {
            addBlockToPdf(pdf, canvas, cursor, usableW, usableH);
        });

        pdf.save(filename);
    }

    window.exportPDF = function exportPDF() {
        if (EXPORTING) return;
        var element = document.getElementById('main-content');
        if (!element) {
            alert('Main content not found.');
            return;
        }

        try {
            getHtml2Canvas();
            getJsPDF();
        } catch (err) {
            alert(err.message + '. Please refresh the page and try again.');
            return;
        }

        EXPORTING = true;
        var filename = defaultFilename();
        var snapshots = [];
        var host = null;
        var htmlEl = document.documentElement;

        closeChrome();
        setOverlay(true, 'Capturing the page at full quality\u2026');
        htmlEl.classList.add('na-exporting');
        document.body.classList.add('na-exporting');

        Promise.resolve()
            .then(function () {
                if (document.fonts && document.fonts.ready) return document.fonts.ready.catch(function () {});
            })
            .then(function () { return wait(80); })
            .then(function () { return nextFrame(); })
            .then(function () {
                resizeCharts(element);
                return nextFrame();
            })
            .then(function () {
                snapshots = snapshotCanvases(element).concat(snapshotMapSvg(element));
                return waitForSnapshots(snapshots).then(function () { return wait(40); });
            })
            .then(function () {
                host = buildCaptureHost(element);
                // allow the fixed-width clone to lay out before we measure it
                return wait(150);
            })
            .then(function () {
                setOverlay(true, 'Building PDF\u2026');
                var blocks = buildBlocks(host);
                return captureAllBlocks(blocks);
            })
            .then(function (canvases) {
                writePdfFromBlocks(canvases, filename);
            })
            .catch(function (err) {
                if (typeof console !== 'undefined' && console.error) console.error(err);
                alert('PDF export failed. Please refresh and try again.');
            })
            .then(function () {
                try { restoreSnapshots(snapshots); } catch (e) {}
                if (host && host.parentNode) host.parentNode.removeChild(host);
                htmlEl.classList.remove('na-exporting');
                document.body.classList.remove('na-exporting');
                setOverlay(false);
                try { resizeCharts(element); } catch (e) {}
                EXPORTING = false;
            });
    };
})();