/**
 * TOAST.JS - Simple notification system
 * Replaces iziToast with lightweight native implementation
 */

const Toast = {
    success: function(options) {
        this.show('success', options.title || 'Success', options.message || '');
        if (options.onClosed) {
            setTimeout(() => options.onClosed(), 3000);
        }
    },
    
    error: function(options) {
        this.show('error', options.title || 'Error', options.message || '');
        if (options.onClosed) {
            setTimeout(() => options.onClosed(), 3000);
        }
    },
    
    info: function(options) {
        this.show('info', options.title || 'Info', options.message || '');
        if (options.onClosed) {
            setTimeout(() => options.onClosed(), 3000);
        }
    },

    show: function(type, title, message) {
        // Create container if not exists
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        // Create toast element
        const toastEl = document.createElement('div');
        toastEl.className = `toast-message ${type}`;
        toastEl.innerHTML = `
            <div style="font-weight: 600; margin-bottom: 4px;">${title}</div>
            <div style="font-size: 14px;">${message}</div>
        `;

        container.appendChild(toastEl);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toastEl.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toastEl.remove(), 300);
        }, 3000);
    }
};

// Fallback for iziToast calls
if (typeof iziToast === 'undefined') {
    window.iziToast = Toast;
}
