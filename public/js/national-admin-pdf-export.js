/**
 * National Admin PDF export.
 * Uses html2canvas + jsPDF directly (html2pdf.bundle does not expose either global).
 */
(function () {
    'use strict';

    var EXPORTING = false;
    var CAPTURE_WIDTH = 1280;
    var MAX_CANVAS = 8192;
    var A3_W = 420;
    var A3_H = 297;
    var MARGIN = 10;

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

    function buildCaptureHost(source) {
        var existing = document.getElementById('na-pdf-capture-host');
        if (existing && existing.parentNode) existing.parentNode.removeChild(existing);

        var host = document.createElement('div');
        host.id = 'na-pdf-capture-host';
        var clone = source.cloneNode(true);
        clone.removeAttribute('id');
        clone.style.width = '100%';
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

    function canvasOptions(node) {
        var width = Math.max(CAPTURE_WIDTH, node.scrollWidth || CAPTURE_WIDTH);
        var height = Math.max(node.scrollHeight || 0, node.offsetHeight || 0, 1);
        return {
            scale: pickScale(width, height),
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
            scrollX: 0,
            scrollY: 0,
            width: width,
            height: height,
            windowWidth: width,
            windowHeight: height
        };
    }

    function captureToCanvas(node) {
        return getHtml2Canvas()(node, canvasOptions(node));
    }

    function writePdfFromCanvas(canvas, filename) {
        if (!canvas || !canvas.width || !canvas.height) {
            throw new Error('Page capture was empty');
        }

        var JsPDF = getJsPDF();
        var usableW = A3_W - MARGIN * 2;
        var usableH = A3_H - MARGIN * 2;
        var imgW = canvas.width;
        var imgH = canvas.height;
        var pageHeightPx = Math.max(1, Math.floor(imgW * (usableH / usableW)));

        var pdf = new JsPDF({ unit: 'mm', format: 'a3', orientation: 'landscape' });
        var y = 0;
        var page = 0;

        while (y < imgH - 1) {
            if (page > 0) pdf.addPage([A3_W, A3_H], 'landscape');
            pdf.setFillColor(255, 255, 255);
            pdf.rect(0, 0, A3_W, A3_H, 'F');

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
            page += 1;
            if (page > 40) break;
        }

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
                return wait(100);
            })
            .then(function () {
                setOverlay(true, 'Building PDF\u2026');
                return captureToCanvas(host).catch(function () {
                    return captureToCanvas(element);
                });
            })
            .then(function (canvas) {
                writePdfFromCanvas(canvas, filename);
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
