// Real-time Notification Poller - INSTANT UPDATES
// Polls every 5 seconds for near-instant notification delivery

class NotificationPoller {
    constructor() {
        this.lastCheckTime = new Date().toISOString();
        this.pollInterval = 5000; // 5 seconds for instant responsiveness
        this.isPolling = false;
        this.lastNotificationCount = 0;
    }

    start() {
        if (this.isPolling) return;

        this.isPolling = true;

        // Poll immediately on start
        this.poll();

        // Poll interval in milliseconds (5 seconds for near-instant updates)

        // Set up interval
        this.intervalId = setInterval(() => {
            this.poll();
        }, this.pollInterval);

        console.log('🔔 Notification polling started (every 5 seconds)');
    }

    stop() {
        this.isPolling = false;
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
        console.log('Notification polling stopped');
    }

    async poll() {
        try {
            const response = await fetch('/notifications/latest?last_check_time=' + encodeURIComponent(this.lastCheckTime), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                console.error('Failed to fetch notifications');
                return;
            }

            const data = await response.json();

            // Check if count increased (new notification!)
            if (data.unread_count > this.lastNotificationCount && this.lastNotificationCount > 0) {
                console.log('🔔 NEW NOTIFICATION DETECTED!');

                // Play sound for the latest notification
                if (data.latest_notification && data.latest_notification.data) {
                    const soundType = this.getSoundType(data.latest_notification.data.type || data.latest_notification.data.icon);
                    if (window.notificationSounds) {
                        console.log(`🔊 Playing ${soundType} sound`);
                        window.notificationSounds.play(soundType);
                    }
                }

                // Show browser notification
                this.showBrowserNotification(data.latest_notification);
            }

            this.lastNotificationCount = data.unread_count;
            this.lastCheckTime = data.current_time;

            // Update UI
            this.updateUI(data);

        } catch (error) {
            console.error('Notification poll error:', error);
        }
    }

    getSoundType(notificationType) {
        const soundMap = {
            'deal_won': 'success',
            'payment_received': 'success',
            'invoice_overdue': 'warning',
            'invoice_created': 'info',
            'contact_created': 'info',
            'success': 'success',
            'warning': 'warning',
            'error': 'warning',
            'info': 'info',
        };

        return soundMap[notificationType] || 'info';
    }

    showBrowserNotification(notification) {
        if ('Notification' in window && Notification.permission === 'granted') {
            const data = notification.data || {};
            new Notification('LeadiX - ' + (data.type || 'New Notification'), {
                body: data.message || 'You have a new notification',
                icon: '/favicon.ico',
                tag: notification.id
            });
        }
    }

    updateUI(data) {
        // Update unread count badge
        const badge = document.querySelector('[data-notification-badge]');
        if (badge) {
            if (data.unread_count > 0) {
                badge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                badge.style.display = 'flex';
                console.log(`📊 Badge updated: ${data.unread_count} unread`);
            } else {
                badge.style.display = 'none';
            }
        }
    }

    // Force immediate poll
    pollNow() {
        console.log('🔄 Manual refresh triggered');
        this.poll();
    }
}

// Initialize and start polling when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.notificationPoller = new NotificationPoller();
    window.notificationPoller.start();

    console.log('✅ Notification system ready');
});

// Global function to manually refresh
window.refreshNotifications = function () {
    if (window.notificationPoller) {
        window.notificationPoller.pollNow();
    }
};

// Request browser notification permission
document.addEventListener('click', () => {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission().then(permission => {
            console.log('📢 Browser notification permission:', permission);
        });
    }
}, { once: true });
