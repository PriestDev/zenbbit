/* ========================================
   NAVBAR & SIDEBAR INTERACTIVE FUNCTIONALITY
   ======================================== */

(function() {
    'use strict';
    
    var navbarState = {
        isMobile: function() {
            return window.innerWidth <= 768;
        },
        sidebarOpen: false
    };
    
    // ===========================================
    // 1. MOBILE SIDEBAR TOGGLE
    // ===========================================
    function initMobileSidebarToggle() {
        var toggleBtn = document.querySelector('.toggle-sidebar-btn');
        var sidebar = document.getElementById('sidebar');
        var body = document.body;
        
        if (!toggleBtn) {
            console.error('[Navbar] Toggle button not found: .toggle-sidebar-btn');
            return;
        }
        if (!sidebar) {
            console.error('[Navbar] Sidebar not found: #sidebar');
            return;
        }
        
        console.log('[Navbar] Mobile sidebar toggle initialized');
        
        // Open/Close sidebar on toggle button click
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('[Navbar] Toggle button clicked, current state:', navbarState.sidebarOpen);
            
            navbarState.sidebarOpen = !navbarState.sidebarOpen;
            
            if (navbarState.sidebarOpen) {
                console.log('[Navbar] Opening sidebar');
                sidebar.classList.add('mobile-open');
                body.classList.add('sidebar-open');
            } else {
                console.log('[Navbar] Closing sidebar');
                sidebar.classList.remove('mobile-open');
                body.classList.remove('sidebar-open');
            }
        });
        
        // Close sidebar when clicking on a nav link
        var navLinks = sidebar.querySelectorAll('.nav-link, .collapse-item');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                // Only close if it's a navigation link (has href), not collapse trigger
                if (this.href && !this.hasAttribute('data-toggle')) {
                    navbarState.sidebarOpen = false;
                    sidebar.classList.remove('mobile-open');
                    body.classList.remove('sidebar-open');
                }
            });
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (!navbarState.isMobile()) return;
            
            var isClickInsideSidebar = e.target.closest('#sidebar');
            var isClickOnToggle = e.target.closest('.toggle-sidebar-btn');
            
            if (!isClickInsideSidebar && !isClickOnToggle && navbarState.sidebarOpen) {
                navbarState.sidebarOpen = false;
                sidebar.classList.remove('mobile-open');
                body.classList.remove('sidebar-open');
            }
        });
        
        // Close sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            if (!navbarState.isMobile() && navbarState.sidebarOpen) {
                navbarState.sidebarOpen = false;
                sidebar.classList.remove('mobile-open');
                body.classList.remove('sidebar-open');
            }
        });
    }
    
    // ===========================================
    // 2. COLLAPSE/ACCORDION FUNCTIONALITY
    // ===========================================
    function initCollapseMenus() {
        var triggers = document.querySelectorAll('[data-toggle="collapse"]');
        
        if (!triggers.length) {
            console.warn('[Navbar] No collapse triggers found');
            return;
        }
        
        triggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var targetId = this.getAttribute('data-target');
                
                // Normalize selector
                if (!targetId) return;
                if (targetId.charAt(0) !== '#') {
                    targetId = '#' + targetId;
                }
                
                var target = document.querySelector(targetId);
                if (!target) {
                    console.warn('[Navbar] Collapse target not found:', targetId);
                    return;
                }
                
                // Get parent for accordion behavior
                var parentId = target.getAttribute('data-parent');
                var parentEl = parentId ? document.querySelector(parentId) : null;
                
                // Close all other expanded items in same parent
                if (parentEl) {
                    var allCollapses = parentEl.querySelectorAll('.collapse');
                    allCollapses.forEach(function(collapseItem) {
                        if (collapseItem !== target) {
                            collapseItem.classList.add('collapse-closed');
                            
                            // Update the trigger for this collapsed item
                            var itemId = collapseItem.getAttribute('id');
                            if (itemId) {
                                var relatedTrigger = document.querySelector('[data-target="#' + itemId + '"], [data-target="' + itemId + '"]');
                                if (relatedTrigger) {
                                    relatedTrigger.setAttribute('aria-expanded', 'false');
                                    relatedTrigger.classList.add('collapsed');
                                }
                            }
                        }
                    });
                }
                
                // Toggle current target collapse-closed state
                var isClosed = target.classList.contains('collapse-closed');
                if (isClosed) {
                    target.classList.remove('collapse-closed');
                    this.setAttribute('aria-expanded', 'true');
                    this.classList.remove('collapsed');
                } else {
                    target.classList.add('collapse-closed');
                    this.setAttribute('aria-expanded', 'false');
                    this.classList.add('collapsed');
                }
            });
        });
    }
    
    // ===========================================
    // 3. NOTIFICATION DROPDOWN TOGGLE
    // ===========================================
    function initNotificationDropdown() {
        var notificationBtn = document.querySelector('.notification-trigger');
        var notificationWrapper = document.querySelector('.notification-dropdown-wrapper');
        var notificationMenu = document.querySelector('.notification-dropdown-menu');
        
        if (!notificationBtn || !notificationWrapper || !notificationMenu) return;
        
        notificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close profile dropdown
            var profileWrapper = document.querySelector('.profile-dropdown-wrapper');
            if (profileWrapper) {
                profileWrapper.classList.remove('show');
            }
            
            // Toggle notification dropdown
            var isOpen = notificationWrapper.classList.contains('show');
            notificationWrapper.classList.toggle('show');
            
            // Position dropdown correctly
            if (!isOpen) {
                positionDropdown(notificationBtn, notificationMenu);
            }
        });
    }
    
    // ===========================================
    // 4. PROFILE DROPDOWN TOGGLE
    // ===========================================
    function initProfileDropdown() {
        var profileBtn = document.querySelector('.profile-dropdown-trigger');
        var profileWrapper = document.querySelector('.profile-dropdown-wrapper');
        var profileMenu = document.querySelector('.profile-dropdown-menu');
        
        if (!profileBtn || !profileWrapper || !profileMenu) return;
        
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close notification dropdown
            var notificationWrapper = document.querySelector('.notification-dropdown-wrapper');
            if (notificationWrapper) {
                notificationWrapper.classList.remove('show');
            }
            
            // Toggle profile dropdown
            var isOpen = profileWrapper.classList.contains('show');
            profileWrapper.classList.toggle('show');
            
            // Position dropdown correctly
            if (!isOpen) {
                positionDropdown(profileBtn, profileMenu);
            }
        });
    }
    
    // ===========================================
    // 5. CLOSE DROPDOWNS ON OUTSIDE CLICK
    // ===========================================
    function initDropdownAutoClose() {
        document.addEventListener('click', function(e) {
            var notificationWrapper = document.querySelector('.notification-dropdown-wrapper');
            var profileWrapper = document.querySelector('.profile-dropdown-wrapper');
            
            // Close notification dropdown if clicking outside
            if (notificationWrapper && !e.target.closest('.notification-dropdown-wrapper')) {
                notificationWrapper.classList.remove('show');
            }
            
            // Close profile dropdown if clicking outside
            if (profileWrapper && !e.target.closest('.profile-dropdown-wrapper')) {
                profileWrapper.classList.remove('show');
            }
        });
    }
    
    // ===========================================
    // DROPDOWN POSITIONING HELPER
    // ===========================================
    function positionDropdown(triggerBtn, dropdownMenu) {
        var triggerRect = triggerBtn.getBoundingClientRect();
        var dropdownRect = dropdownMenu.getBoundingClientRect();
        var gap = 8; // pixels
        
        // Position below button
        var top = triggerRect.bottom + gap;
        var right = window.innerWidth - triggerRect.right;
        
        // Adjust if dropdown goes off-screen
        if (top + dropdownRect.height > window.innerHeight) {
            top = triggerRect.top - dropdownRect.height - gap;
        }
        
        // Ensure dropdown doesn't go off right edge
        if (right - dropdownRect.width < 0) {
            right = 10; // 10px margin from right
        }
        
        dropdownMenu.style.top = top + 'px';
        dropdownMenu.style.right = right + 'px';
    }
    
    // ===========================================
    // 6. THEME TOGGLE - Applies to entire page
    // ===========================================
    function initThemeToggle() {
        var themeToggle = document.getElementById('themeToggle');
        if (!themeToggle) {
            console.warn('[Navbar] Theme toggle button not found');
            return;
        }
        
        // Check current theme from localStorage
        var currentTheme = localStorage.getItem('admin-theme') || 'light';
        updateThemeButton(currentTheme);
        applyTheme(currentTheme);
        
        themeToggle.addEventListener('click', function() {
            var theme = localStorage.getItem('admin-theme') || 'light';
            var newTheme = theme === 'light' ? 'dark' : 'light';
            
            localStorage.setItem('admin-theme', newTheme);
            applyTheme(newTheme);
            updateThemeButton(newTheme);
        });
        
        function applyTheme(theme) {
            // Apply to html element for CSS variables
            document.documentElement.setAttribute('data-theme', theme);
            
            // Apply to body for backwards compatibility
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.body.classList.remove('dark-mode');
            }
        }
        
        function updateThemeButton(theme) {
            if (!themeToggle) return;
            
            var icon = themeToggle.querySelector('i');
            var text = themeToggle.querySelector('span');
            
            // Update button classes
            if (theme === 'dark') {
                themeToggle.classList.remove('btn-secondary');
                themeToggle.classList.add('btn-warning');
            } else {
                themeToggle.classList.remove('btn-warning');
                themeToggle.classList.add('btn-secondary');
            }
            
            // Update icon if it exists
            if (icon) {
                icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
            
            // Update text if it exists
            if (text) {
                text.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
            }
        }
    }
    
    // ===========================================
    // INITIALIZE ALL WHEN DOM IS READY
    // ===========================================
    function init() {
        initMobileSidebarToggle();
        initCollapseMenus();
        initNotificationDropdown();
        initProfileDropdown();
        initDropdownAutoClose();
        initThemeToggle();
    }
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
