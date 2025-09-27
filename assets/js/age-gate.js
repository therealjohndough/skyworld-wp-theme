/**
 * Skyworld Age Gate
 * Displays age verification modal for first-time visitors
 */
(function() {
    'use strict';

    // Age gate configuration
    const AGE_GATE_CONFIG = {
        cookieName: 'skyworld_age_verified',
        cookieExpiry: 30, // days
        minimumAge: 21,
        rememberDays: 30
    };

    // Check if user has already been verified
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Set cookie
    function setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Strict`;
    }

    // Create age gate HTML
    function createAgeGateHTML() {
        return `
            <div id="skyworld-age-gate" class="skyworld-age-gate-overlay" style="display: none;">
                <div class="skyworld-age-gate-modal">
                    <div class="skyworld-age-gate-content">
                        <div class="skyworld-age-gate-logo">
                            <img src="${window.skyworldAgeGate.logoUrl}" alt="Skyworld Cannabis" />
                        </div>
                        <h2>Are you at least 21 years of age?</h2>
                        <p>You must be 21 or older to enter this site. Please verify your age to continue.</p>
                        <div class="skyworld-age-gate-buttons">
                            <button id="skyworld-age-yes" class="btn-yes">Yes!</button>
                            <button id="skyworld-age-no" class="btn-no">No</button>
                        </div>
                        <div class="skyworld-age-gate-remember">
                            <label>
                                <input type="checkbox" id="skyworld-remember-me" checked />
                                Remember me
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Show age gate
    function showAgeGate() {
        const ageGateHTML = createAgeGateHTML();
        document.body.insertAdjacentHTML('beforeend', ageGateHTML);
        
        const overlay = document.getElementById('skyworld-age-gate');
        const yesBtn = document.getElementById('skyworld-age-yes');
        const noBtn = document.getElementById('skyworld-age-no');
        const rememberCheckbox = document.getElementById('skyworld-remember-me');

        // Show overlay
        overlay.style.display = 'flex';
        document.body.classList.add('age-gate-active');

        // Handle YES button
        yesBtn.addEventListener('click', function() {
            const rememberMe = rememberCheckbox.checked;
            const expireDays = rememberMe ? AGE_GATE_CONFIG.rememberDays : 1;
            
            setCookie(AGE_GATE_CONFIG.cookieName, 'verified', expireDays);
            
            overlay.style.display = 'none';
            document.body.classList.remove('age-gate-active');
            overlay.remove();
        });

        // Handle NO button
        noBtn.addEventListener('click', function() {
            window.location.href = 'https://www.google.com';
        });

        // Prevent closing by clicking overlay
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                e.preventDefault();
                e.stopPropagation();
            }
        });

        // Prevent keyboard shortcuts to close
        document.addEventListener('keydown', function(e) {
            if (document.body.classList.contains('age-gate-active')) {
                if (e.key === 'Escape' || e.key === 'Tab') {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
        });
    }

    // Initialize age gate
    function initAgeGate() {
        // Check if already verified
        const verified = getCookie(AGE_GATE_CONFIG.cookieName);
        
        if (!verified) {
            // Small delay to ensure page is loaded
            setTimeout(showAgeGate, 500);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAgeGate);
    } else {
        initAgeGate();
    }

})();