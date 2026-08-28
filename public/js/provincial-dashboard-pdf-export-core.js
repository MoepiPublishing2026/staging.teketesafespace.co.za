(function () {
    'use strict';

    var EXPORTING = false;

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
                img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(xml);
                img.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:contain;display:block;';
                svg.style.display = 'none';
                svg.parentNode.insertBefore(img, svg);
                snaps.push({ svg: svg, img: img });
            } catch (err) { /* leave original */ }
        });
        return snaps;
    }

    function restoreMapSnaps(snaps) {
        (snaps || []).forEach(function (item) {
            if (item.svg) item.svg.style.display = '';
            if (item.img && item.img.parentNode) item.img.parentNode.removeChild(item.img);
        });
    }

    window.exportPDF = function exportPDF() {
        if (EXPORTING) return;
        var element = document.getElementById('main-content');
        if (!element) {
            alert('Main content not found.');
            return;
        }
        if (!window.NA_PDF_CORE) {
            alert('PDF export module not loaded. Please refresh and try again.');
            return;
        }

        EXPORTING = true;
        setOverlay(true, 'Capturing the page at full quality\u2026');

        window.NA_PDF_CORE.run({
            scrollRoot: element,
            filename: (function () {
                var path = (window.location.pathname || '').toLowerCase();
                if (path.indexOf('heatmap') !== -1) return 'national-admin-heatmap.pdf';
                if (path.indexOf('reports') !== -1) return 'national-admin-reports.pdf';
                return 'National-admin-dashboard.pdf';
            })(),
            beforeCapture: closeChrome,
            extraSnapshot: function (root) {
                var snaps = snapshotMapSvg(root);
                return { snaps: snaps, ready: Promise.resolve() };
            }
        }).then(function () {
            restoreMapSnaps([]); // noop placeholder; core already restores via extraSnapshot's returned snaps
        }).catch(function (err) {
            if (typeof console !== 'undefined' && console.error) console.error(err);
            alert('PDF export failed. Please refresh and try again.');
        }).then(function () {
            setOverlay(false);
            EXPORTING = false;
        });
    };
})();