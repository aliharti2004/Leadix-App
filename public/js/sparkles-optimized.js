// Optimized Sparkle Animation - Reduced lag
function createOptimizedSparkles() {
    const container = document.getElementById('sparkles');
    let particleCount = 0;
    const MAX_PARTICLES = 30; // Limit max particles on screen

    setInterval(() => {
        // Only create new sparkle if under limit
        if (particleCount >= MAX_PARTICLES) return;

        const sparkle = document.createElement('div');
        sparkle.className = 'sparkle';

        const size = Math.random() * 3 + 2;
        sparkle.style.width = size + 'px';
        sparkle.style.height = size + 'px';
        sparkle.style.left = Math.random() * 100 + '%';
        sparkle.style.bottom = '0';

        const duration = Math.random() * 3 + 3;
        const endX = (Math.random() - 0.5) * 200;
        const endY = -(Math.random() * 300 + 200);

        sparkle.style.setProperty('--duration', duration + 's');
        sparkle.style.setProperty('--end-x', endX + 'px');
        sparkle.style.setProperty('--end-y', endY + 'px');

        container.appendChild(sparkle);
        particleCount++;

        setTimeout(() => {
            sparkle.remove();
            particleCount--;
        }, duration * 1000);
    }, 400); // Reduced from 200ms to 400ms
}

createOptimizedSparkles();
