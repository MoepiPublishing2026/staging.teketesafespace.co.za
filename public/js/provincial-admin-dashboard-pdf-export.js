(function () {
    'use strict';

    var EXPORTING = false;

    function closeChrome() {
        document.querySelectorAll('.modal-backdrop.active, .modal-backdrop[aria-hidden="false"]').forEach(function (m) {
            m.classList.remove('active');
            m.setAttribute('aria-hidden', 'true');
            if (m.style && m.style.display === 'flex') m.style.display = 'none';
        });
    }

    window.exportPDF = function exportPDF() {
        if (EXPORTING) return;
        var element = document.getElementById('main-content');
        if (!element) {
            alert("Main content not found! Add id='main-content' to your <main> tag.");
            return;
        }
        if (!window.NA_PDF_CORE) {
            alert('PDF export module not loaded. Please refresh and try again.');
            return;
        }

        EXPORTING = true;

        window.NA_PDF_CORE.run({
            scrollRoot: element,
            filename: 'provincial-admin-dashboard.pdf',
            beforeCapture: closeChrome
        }).catch(function (err) {
            if (typeof console !== 'undefined' && console.error) console.error(err);
            alert('PDF export failed. Please refresh and try again.');
        }).then(function () {
            EXPORTING = false;
        });
    };
})();