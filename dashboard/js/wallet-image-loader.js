/**
 * WALLET_IMAGE_LOADER.JS
 * Lazy loads wallet logos from cache using Intersection Observer
 * Improves page load performance by deferring image loading
 */

(function() {
    'use strict';

    // Initialize lazy image loading
    function initLazyImageLoading() {
        const lazyImages = document.querySelectorAll('img.lazy-img[data-src]');
        
        if (lazyImages.length === 0) return;

        // Check if Intersection Observer is supported
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');
                        
                        if (src) {
                            img.src = src;
                            img.removeAttribute('data-src');
                            img.classList.remove('lazy-img');
                            img.classList.add('loaded-img');
                            observer.unobserve(img);
                        }
                    }
                });
            }, {
                rootMargin: '50px' // Start loading 50px before element enters viewport
            });

            lazyImages.forEach(img => {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for browsers without IntersectionObserver support
            lazyImages.forEach(img => {
                const src = img.getAttribute('data-src');
                if (src) {
                    img.src = src;
                    img.removeAttribute('data-src');
                    img.classList.remove('lazy-img');
                    img.classList.add('loaded-img');
                }
            });
        }
    }

    // Load images when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLazyImageLoading);
    } else {
        initLazyImageLoading();
    }
})();
