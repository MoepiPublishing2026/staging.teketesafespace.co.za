(function () {
    if (window.__adminAutoLogoutStarted) {
        return;
    }

    const config = window.AdminAutoLogout;
    if (!config || !config.timeoutMinutes) {
        return;
    }

    window.__adminAutoLogoutStarted = true;

    const INACTIVITY_TIMEOUT_MS = config.timeoutMinutes * 60 * 1000;
    let timeoutTimer = null;

    function csrfToken() {
        return config.csrfToken
            || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            || '';
    }

    function performLogout() {
        const token = csrfToken();
        const body = new URLSearchParams();
        if (token) {
            body.set('_token', token);
        }

        fetch(config.logoutUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: body.toString(),
        }).finally(function () {
            var loginUrl = config.loginUrl || '/school-admin';
            window.location.replace(loginUrl + (loginUrl.indexOf('?') >= 0 ? '&' : '?') + 'session_expired=1');
        });
    }

    function resetTimer() {
        clearTimeout(timeoutTimer);
        timeoutTimer = setTimeout(function () {
            performLogout();
        }, INACTIVITY_TIMEOUT_MS);
    }

    function setupInactivityTracking() {
        const activityEvents = [
            'mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click',
        ];

        activityEvents.forEach(function (eventName) {
            document.addEventListener(eventName, resetTimer, { passive: true });
        });

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                resetTimer();
            } else {
                clearTimeout(timeoutTimer);
            }
        });

        resetTimer();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupInactivityTracking);
    } else {
        setupInactivityTracking();
    }
})();
