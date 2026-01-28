/**
 * WALLET_IMAGE_LOADER.JS
 * Loads wallet logos from data-src with fallback placeholders
 */

(function() {
    'use strict';

    function loadWalletImages() {
        const lazyImages = document.querySelectorAll('img.lazy-img[data-src]');
        
        if (lazyImages.length === 0) return;

        lazyImages.forEach(img => {
            const src = img.getAttribute('data-src');
            
            if (!src) return;
            
            // Create a new image to load asynchronously
            const newImg = new Image();
            
            newImg.onload = function() {
                img.src = src;
                img.classList.remove('lazy-img');
                img.classList.add('loaded-img');
            };
            
            newImg.onerror = function() {
                // If CDN fails, keep placeholder
                console.warn('Failed to load wallet logo:', src);
            };
            
            // Start loading
            newImg.src = src;
        });
    }

    // Load images when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadWalletImages);
    } else {
        loadWalletImages();
    }
})();
