document.addEventListener("DOMContentLoaded", function () {
    if (typeof gsap === 'undefined') {
        console.error('GSAP library is not loaded. Please include the GSAP script.');
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const productContainers = document.querySelectorAll('.products-list-container');
    productContainers.forEach(container => {
        const productItems = container.querySelectorAll('.product-item');
        
        gsap.set(productItems, { 
            opacity: 0, 
            y: 30
        });
      
        ScrollTrigger.create({
            trigger: container,
            start: "top 80%", 
            once: true,
            onEnter: () => {
                gsap.to(productItems, {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: "power2.out",
                    stagger: {
                        amount: 0.6, 
                        grid: [Math.ceil(productItems.length / 4), 4], 
                        from: "start", 
                    }
                });
            },
            markers: false, 
        });
    });
});