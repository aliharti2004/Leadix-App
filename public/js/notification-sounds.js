// Notification Sound System - Uses HTML5 Audio API with Base64 encoded sounds
// This creates actual working sounds without needing MP3 files

class NotificationSounds {
    constructor() {
        // Create AudioContext for sound generation
        this.audioContext = null;
        this.muted = localStorage.getItem('notificationsMuted') === 'true';
        this.volume = parseFloat(localStorage.getItem('notificationsVolume') || '0.5');
    }

    // Initialize AudioContext (must be done after user interaction)
    initAudio() {
        if (!this.audioContext) {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        }
    }

    // Play success sound (higher pitched, pleasant)
    playSuccess() {
        if (this.muted) return;
        this.initAudio();

        const ctx = this.audioContext;
        const oscillator = ctx.createOscillator();
        const gainNode = ctx.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(ctx.destination);

        oscillator.frequency.setValueAtTime(523.25, ctx.currentTime); // C5
        oscillator.frequency.setValueAtTime(659.25, ctx.currentTime + 0.1); // E5
        oscillator.frequency.setValueAtTime(783.99, ctx.currentTime + 0.2); // G5

        gainNode.gain.setValueAtTime(this.volume, ctx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);

        oscillator.start(ctx.currentTime);
        oscillator.stop(ctx.currentTime + 0.4);
    }

    // Play warning sound (lower, urgent)
    playWarning() {
        if (this.muted) return;
        this.initAudio();

        const ctx = this.audioContext;

        for (let i = 0; i < 3; i++) {
            const oscillator = ctx.createOscillator();
            const gainNode = ctx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(ctx.destination);

            oscillator.frequency.value = 440; // A4
            oscillator.type = 'square';

            const startTime = ctx.currentTime + (i * 0.15);
            gainNode.gain.setValueAtTime(this.volume, startTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + 0.1);

            oscillator.start(startTime);
            oscillator.stop(startTime + 0.1);
        }
    }

    // Play info sound (subtle, single tone)
    playInfo() {
        if (this.muted) return;
        this.initAudio();

        const ctx = this.audioContext;
        const oscillator = ctx.createOscillator();
        const gainNode = ctx.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(ctx.destination);

        oscillator.frequency.value = 800;
        oscillator.type = 'sine';

        gainNode.gain.setValueAtTime(this.volume * 0.6, ctx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);

        oscillator.start(ctx.currentTime);
        oscillator.stop(ctx.currentTime + 0.2);
    }

    play(type) {
        if (this.muted) return;

        try {
            if (type === 'success') {
                this.playSuccess();
            } else if (type === 'warning') {
                this.playWarning();
            } else {
                this.playInfo();
            }
        } catch (err) {
            console.log('Sound play failed:', err);
        }
    }

    toggleMute() {
        this.muted = !this.muted;
        localStorage.setItem('notificationsMuted', this.muted);
        return this.muted;
    }

    setVolume(volume) {
        this.volume = Math.max(0, Math.min(1, volume));
        localStorage.setItem('notificationsVolume', this.volume);
    }
}

// Export for global use
window.notificationSounds = new NotificationSounds();

// Initialize audio on first user interaction
document.addEventListener('click', () => {
    window.notificationSounds.initAudio();
}, { once: true });
