<!-- Header Navigation Component -->
<div class="header">
    <button id="toggleSidebarBtn" class="toggle-sidebar-btn">
        <i class="fas fa-bars"></i>
    </button>

    <div class="header-actions">
        <!-- Notification Dropdown -->
        <div class="notification-wrapper">
            <button id="notifBtn" class="icon-btn">
                <i class="bi bi-bell"></i>
                <span class="badge" id="notifBadge">0</span>
            </button>

            <div id="notifDropdown" class="dropdown" aria-hidden="true">
                <h4>Notifications</h4>
                <div id="notifList" style="max-height: 400px; overflow-y: auto;">
                    <div style="text-align: center; padding: 20px; color: #aaa;">
                        <i class="fas fa-spinner fa-spin"></i> Loading notifications...
                    </div>
                </div>
                <button id="markReadBtn" class="mark-btn">Mark all as read</button>
            </div>
        </div>

        <!-- Dark/Light Mode Toggle -->
        <button id="themeToggleBtn" class="toggle-btn icon-btn" aria-label="Toggle theme">
            <i class="fas fa-moon icon-purple"></i>
        </button>
    </div>
</div>

<script>
/**
 * NOTIFICATIONS MODULE
 * Fetches and displays real-time notifications from database
 */

const NotificationsModule = {
    // Configuration
    apiEndpoint: 'fetch_notifications.php',
    refreshInterval: 30000, // 30 seconds
    refreshTimer: null,

    // Initialize notifications
    init: function() {
        this.attachEventListeners();
        this.loadNotifications();
        this.setupAutoRefresh();
    },

    // Attach event listeners
    attachEventListeners: function() {
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const markReadBtn = document.getElementById('markReadBtn');

        // Toggle dropdown
        if (notifBtn) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = notifDropdown.getAttribute('aria-hidden') === 'true';
                const willShow = isHidden;
                notifDropdown.setAttribute('aria-hidden', willShow ? 'false' : 'true');
                document.body.classList.toggle('notif-open', willShow);
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.notification-wrapper')) {
                notifDropdown.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('notif-open');
            }
        });

        // Mark all as read
        if (markReadBtn) {
            markReadBtn.addEventListener('click', () => {
                this.markAllAsRead();
            });
        }
    },

    // Load notifications from API
    loadNotifications: function() {
        fetch(this.apiEndpoint)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.displayNotifications(data.notifications, data.count);
                } else {
                    console.error('API Error:', data.message || 'Unknown error');
                    this.showError(data.message || 'Unable to fetch notifications');
                }
            })
            .catch(error => {
                console.error('Notification fetch error:', error);
                this.showError('Unable to fetch notifications. Please check server connection.');
            });
    },

    // Display notifications in dropdown
    displayNotifications: function(notifications, count) {
        const notifList = document.getElementById('notifList');
        const notifBadge = document.getElementById('notifBadge');

        // Update badge count
        notifBadge.textContent = count;
        notifBadge.style.display = count > 0 ? 'flex' : 'none';

        // Clear list
        notifList.innerHTML = '';

        if (!notifications || notifications.length === 0) {
            notifList.innerHTML = `
                <div style="text-align: center; padding: 30px 20px; color: #999;">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                    <p>No notifications yet</p>
                </div>
            `;
            return;
        }

        // Build notification HTML
        notifications.forEach(notif => {
            const notifEl = this.createNotificationElement(notif);
            notifList.appendChild(notifEl);
        });
    },

    // Create individual notification element
    createNotificationElement: function(notif) {
        const div = document.createElement('div');
        div.className = 'notif';
        div.setAttribute('data-notif-id', notif.id);

        // Format time
        const time = this.formatTime(notif.time);

        // Build notification HTML
        let statusClass = '';
        if (notif.status === 'pending') {
            statusClass = 'status-pending';
        } else if (notif.status === 'completed' || notif.status === 'connected') {
            statusClass = 'status-completed';
        } else if (notif.status === 'active') {
            statusClass = 'status-active';
        }

        div.innerHTML = `
            <div class="notif-content">
                <div class="notif-header">
                    <span class="notif-icon">${notif.icon || '🔔'}</span>
                    <div class="notif-title-wrapper">
                        <div class="notif-title">${notif.title || 'Notification'}</div>
                        <span class="notif-time">${time}</span>
                    </div>
                </div>
                <div class="notif-message">${notif.message || ''}</div>
                ${notif.status ? `<div class="notif-status ${statusClass}">${notif.status.charAt(0).toUpperCase() + notif.status.slice(1)}</div>` : ''}
            </div>
        `;

        return div;
    },

    // Format time to relative format
    formatTime: function(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // seconds

        if (diff < 60) return 'Just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';

        return date.toLocaleDateString();
    },

    // Show error message
    showError: function(message) {
        const notifList = document.getElementById('notifList');
        notifList.innerHTML = `
            <div style="text-align: center; padding: 20px; color: #f44336;">
                <i class="fas fa-exclamation-triangle"></i> ${message}
            </div>
        `;
    },

    // Mark all as read
    markAllAsRead: function() {
        const notifList = document.getElementById('notifList');
        const notifs = notifList.querySelectorAll('.notif');

        notifs.forEach(notif => {
            notif.style.opacity = '0.6';
        });

        // Update badge
        document.getElementById('notifBadge').textContent = '0';

        // Show confirmation
        const btn = document.getElementById('markReadBtn');
        const originalText = btn.textContent;
        btn.textContent = '✓ Marked as read';
        setTimeout(() => {
            btn.textContent = originalText;
        }, 2000);
    },

    // Setup auto-refresh
    setupAutoRefresh: function() {
        this.refreshTimer = setInterval(() => {
            this.loadNotifications();
        }, this.refreshInterval);
    },

    // Destroy
    destroy: function() {
        if (this.refreshTimer) {
            clearInterval(this.refreshTimer);
        }
        document.body.classList.remove('notif-open');
    }
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        NotificationsModule.init();
    });
} else {
    NotificationsModule.init();
}

// Cleanup on page unload
window.addEventListener('unload', () => {
    NotificationsModule.destroy();
});
</script>

<style>
/* Notification Styles */
.notif-content {
    padding: 12px 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: background 0.2s ease;
}

body.light-mode .notif-content {
    border-bottom-color: rgba(0, 0, 0, 0.08);
}

.notif-content:hover {
    background: rgba(98, 47, 170, 0.05);
}

body.light-mode .notif-content:hover {
    background: rgba(98, 47, 170, 0.08);
}

.notif-header {
    display: flex;
    gap: 10px;
    margin-bottom: 8px;
}

.notif-icon {
    font-size: 20px;
    min-width: 24px;
    text-align: center;
}

.notif-title-wrapper {
    flex: 1;
    min-width: 0;
}

.notif-title {
    font-weight: 600;
    font-size: 13px;
    color: #fff;
    margin-bottom: 2px;
}

body.light-mode .notif-title {
    color: #1a1a1a;
}

.notif-time {
    font-size: 11px;
    color: #999;
}

body.light-mode .notif-time {
    color: #888;
}

.notif-message {
    font-size: 12px;
    color: #aaa;
    line-height: 1.4;
    margin-bottom: 8px;
    word-wrap: break-word;
}

body.light-mode .notif-message {
    color: #666;
}

.notif-status {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: rgba(255, 165, 0, 0.2);
    color: #ff9800;
}

.status-completed {
    background: rgba(76, 175, 80, 0.2);
    color: #4caf50;
}

.status-active {
    background: rgba(33, 150, 243, 0.2);
    color: #2196f3;
}

/* Dropdown layout and responsive behavior */
.notification-wrapper { position: relative; }

.notification-wrapper .dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 360px;
    max-height: 420px;
    overflow: hidden;
    background: var(--card-bg, #111);
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.35);
    z-index: 1200;
    transition: opacity .16s ease, transform .16s ease;
    opacity: 0;
    transform: translateY(-6px);
    pointer-events: none;
    display: flex;
    flex-direction: column;
}

.notification-wrapper .dropdown[aria-hidden="false"] {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

.notification-wrapper .dropdown #notifList {
    max-height: 360px;
    overflow-y: auto;
}

.notif {
    display: block;
    margin: 0;
}

.notif-content { padding: 14px 16px; }

.icon-btn .badge {
    position: absolute;
    top: 6px;
    right: 6px;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    font-size: 11px;
    align-items: center;
    justify-content: center;
}

@media (max-width: 600px) {
    .notification-wrapper .dropdown {
        position: fixed;
        top: 56px;
        right: 8px;
        left: auto;
        width: calc(100% - 32px);
        max-width: 380px;
        max-height: 60vh;
        height: auto;
        border-radius: 10px;
        padding: 10px;
        overflow: auto;
    }
    .notification-wrapper .dropdown h4 {
        margin-top: 4px;
        margin-bottom: 8px;
        font-size: 16px;
    }
    .notification-wrapper .dropdown #notifList {
        max-height: calc(60vh - 90px);
        overflow-y: auto;
        margin-bottom: 8px;
    }
    .mark-btn {
        position: relative;
        bottom: 0;
        width: 100%;
        box-sizing: border-box;
    }
    /* Do not force-hide body scroll for small dropdown to avoid layout jumps */
    body.notif-open { overflow: auto; }

    /* Limit long message blocks to avoid oversized items */
    .notif-message {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
}
</style>
