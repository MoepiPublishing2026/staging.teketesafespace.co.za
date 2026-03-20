// Set the inactivity timeout to 30 minutes (30 minutes * 60 seconds * 1000 ms)
const INACTIVITY_TIMEOUT_MS = 30 * 60 * 1000; 
let timeoutTimer;

/**
 * Resets the timer whenever user activity is detected (mouse, keypress, scroll, touch).
 */
function resetTimer() {
    clearTimeout(timeoutTimer);
    
    // Set a new timer
    timeoutTimer = setTimeout(() => {
        // Only proceed if a session cookie exists, indicating the user is likely logged in
        if (document.cookie.includes('laravel_session')) {
            console.log('30 minutes of inactivity detected. Logging out.');
            
           
            alert('You have been logged out due to 30 minutes of inactivity.');
            
            
            window.location.href = '/logout'; 
        }
    }, INACTIVITY_TIMEOUT_MS);
}


function setupInactivityTracking() {
    // Events to monitor for activity
    const activityEvents = ['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart'];
    activityEvents.forEach(event => document.addEventListener(event, resetTimer, false));
    
    
    resetTimer();
    console.log(`Auto-logout timer started for 30 minutes.`);
}

// Start tracking once the window is fully loaded
window.onload = setupInactivityTracking;

// Handle browser tab focus/blur to pause/resume the timer
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible') {
        // Resume/reset timer when the tab becomes active again
        resetTimer(); 
    } else {
        // Pause timer when the tab is inactive
        clearTimeout(timeoutTimer);
    }
});