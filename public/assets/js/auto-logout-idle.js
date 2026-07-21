/**
 * Auto Logout on User Inactivity (Idle Timer)
 * Monitors user interactions across tabs and automatically logs out when idle limit is reached.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        // Read idle timeout from meta tag (in seconds) or default to 15 minutes (900 seconds)
        const timeoutMeta = document.querySelector('meta[name="idle-timeout"]');
        const idleTimeoutSeconds = timeoutMeta ? parseInt(timeoutMeta.getAttribute('content'), 10) : 900;
        if (!idleTimeoutSeconds || idleTimeoutSeconds <= 0) return;

        const idleTimeoutMs = idleTimeoutSeconds * 1000;
        const STORAGE_KEY = 'inspinia_last_user_activity';
        let lastActivity = Date.now();
        let logoutTriggered = false;
        let lastUpdateTimestamp = 0;

        // Initialize or read last activity from localStorage for multi-tab synchronization
        try {
            const storedTime = localStorage.getItem(STORAGE_KEY);
            if (storedTime) {
                const parsed = parseInt(storedTime, 10);
                if (!isNaN(parsed) && parsed <= Date.now()) {
                    if (Date.now() - parsed < idleTimeoutMs) {
                        lastActivity = parsed;
                    } else {
                        // Reset to current time on fresh session if stored time is already expired
                        lastActivity = Date.now();
                        localStorage.setItem(STORAGE_KEY, lastActivity.toString());
                    }
                }
            } else {
                localStorage.setItem(STORAGE_KEY, lastActivity.toString());
            }
        } catch (e) {
            // localStorage fallback
        }

        // Check if idle timeout has been reached and trigger logout
        function checkAndLogoutIfIdle() {
            if (logoutTriggered) return true;

            // Re-check localStorage for latest activity across tabs
            try {
                const storedTime = localStorage.getItem(STORAGE_KEY);
                if (storedTime) {
                    const parsed = parseInt(storedTime, 10);
                    if (!isNaN(parsed) && parsed > lastActivity) {
                        lastActivity = parsed;
                    }
                }
            } catch (e) {}

            const elapsedMs = Date.now() - lastActivity;

            if (elapsedMs >= idleTimeoutMs) {
                logoutTriggered = true;
                triggerIdleLogout();
                return true;
            }
            return false;
        }

        // Throttle reset function to avoid performance overhead on frequent events like mousemove
        function handleUserActivity() {
            if (logoutTriggered) return;

            // Check if user has already exceeded idle limit BEFORE updating activity timestamp
            if (checkAndLogoutIfIdle()) {
                return;
            }

            const now = Date.now();
            if (now - lastUpdateTimestamp < 1000) return; // Throttle to 1 second
            
            lastUpdateTimestamp = now;
            lastActivity = now;

            try {
                localStorage.setItem(STORAGE_KEY, now.toString());
            } catch (e) {
                // Ignore storage errors
            }
        }

        // Sync activity across multiple browser tabs
        window.addEventListener('storage', function (e) {
            if (e.key === STORAGE_KEY && e.newValue) {
                const remoteTime = parseInt(e.newValue, 10);
                if (!isNaN(remoteTime) && remoteTime > lastActivity) {
                    lastActivity = remoteTime;
                }
            }
        });

        // Check when tab becomes visible or window regains focus
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                checkAndLogoutIfIdle();
            }
        });

        window.addEventListener('focus', function () {
            checkAndLogoutIfIdle();
        });

        // Listen to user interaction events
        const userEvents = ['mousemove', 'mousedown', 'keydown', 'scroll', 'click', 'touchstart', 'pointermove'];
        userEvents.forEach(function (eventName) {
            window.addEventListener(eventName, handleUserActivity, { passive: true });
        });

        // Periodically check for idle timeout
        const checkInterval = setInterval(function () {
            if (checkAndLogoutIfIdle()) {
                clearInterval(checkInterval);
            }
        }, 2000);

        // Execute logout via POST form submission
        function triggerIdleLogout() {
            const logoutUrlMeta = document.querySelector('meta[name="logout-url"]');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const logoutUrl = logoutUrlMeta ? logoutUrlMeta.getAttribute('content') : '/logout';
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            // Check if topbar logout form exists
            let form = document.getElementById('topbar-logout-form');
            if (form) {
                let reasonInput = form.querySelector('input[name="reason"]');
                if (!reasonInput) {
                    reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    form.appendChild(reasonInput);
                }
                reasonInput.value = 'idle';
                form.submit();
                return;
            }

            // Fallback: create dynamic form
            form = document.createElement('form');
            form.method = 'POST';
            form.action = logoutUrl;

            if (csrfToken) {
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = csrfToken;
                form.appendChild(tokenInput);
            }

            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'reason';
            reasonInput.value = 'idle';
            form.appendChild(reasonInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
})();
