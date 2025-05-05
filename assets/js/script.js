document.addEventListener('DOMContentLoaded', function() {
    // Check if device is mobile
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    // Only create and run the cursor follower on non-mobile devices
    if (!isMobile) {
        // Create the image element
        const followerImage = document.createElement('img');
        
        followerImage.src = maguraScript.mouseImagePath; 
        followerImage.alt = 'Cursor follower';
        followerImage.id = 'mouse-follower';
        
        // Add styles to the image
        Object.assign(followerImage.style, {
            position: 'fixed',
            width: '50px',
            height: '50px',
            pointerEvents: 'none',
            zIndex: '9999',
            transform: 'translate(-50%, -50%)'
        });
        
        // Append the image to the body
        document.body.appendChild(followerImage);
        
        // Mouse movement tracking variables
        let mouseX = 0;
        let mouseY = 0;
        let currentX = 0;
        let currentY = 0;
        let prevMouseX = 0;
        let prevMouseY = 0;
        let directionX = 0;
        let directionY = 0;
        
        // Set up GSAP
        if (typeof gsap !== 'undefined') {
            // Update mouse position on mouse move
            document.addEventListener('mousemove', function(e) {
                // Store previous position before updating
                prevMouseX = mouseX;
                prevMouseY = mouseY;
                
                // Update current mouse position
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                // Calculate movement direction
                directionX = mouseX - prevMouseX;
                directionY = mouseY - prevMouseY;
                
                // Normalize direction vector (if there is movement)
                const magnitude = Math.sqrt(directionX * directionX + directionY * directionY);
                if (magnitude > 0) {
                    directionX /= magnitude;
                    directionY /= magnitude;
                }
            });
            
            // Animate the follower with GSAP
            gsap.ticker.add(() => {
                // Calculate smooth movement using linear interpolation (LERP)
                const speed = 0.15;
                currentX += (mouseX - currentX) * speed;
                currentY += (mouseY - currentY) * speed;
                
                // Apply the position with GSAP animation (duration: 0.03s)
                gsap.to(followerImage, {
                    duration: 0.2,
                    left: currentX,
                    top: currentY,
                    ease: "power1.out"
                });
            });
        } else {
            console.warn("GSAP not loaded. Please include the GSAP library.");
        }
    }
});
