document.addEventListener("DOMContentLoaded", function () {
    // Check if GSAP is loaded
    if (typeof gsap === 'undefined') {
        console.error('GSAP library is not loaded. Please include the GSAP script.');
        return;
    }

    const headingTl = gsap.timeline();
    headingTl.from("#headliner-text-castiga", {
        duration: 0.3,
        opacity: 0,
        y: 100,
        ease: "power2.out",
        delay: 0.4,
    }).from("#headliner-text-cu", {
        duration: 0.2,
        scaleX: 0.5,
        opacity: 0,
        x:-50,
        transformOrigin: "left",
        ease: "power2.out",
    }).from("#headliner-logo", {
        opacity: 0,
        duration:0.2,
        ease: "power2.out",
    }).from("#headliner-text-dintr-o", {
        opacity: 0,
        duration:0.3,
        scaleY: 0.5,
        y:-50,
        rotateX: 90,
        transformOrigin: "top",
        ease: "power2.out",
    },"=+0.1").from("#headliner-text-imbratisare", {
        opacity: 0,
        duration:0.3,
        y:-100,
        transformOrigin: "top",
        ease: "power2.out",
    }).from(".hero-cta", {
        y: 50,
        opacity: 0,
        delay: 0.2,
        duration: 0.2,
        ease: "power2.out",
    });

    gsap.registerPlugin(ScrollTrigger);
    gsap.registerPlugin(DrawSVGPlugin) 
    
    gsap.from(".magura-map-container", {
        scrollTrigger: {
            trigger: ".magura-map-section",
            start: "40% center",
            end: "bottom 20%",
            onEnter: function() {
                const mapVisibleEvent = new CustomEvent('mapSectionVisible', {
                    detail: {
                        timestamp: Date.now(),
                        triggerElement: ".magura-map-section"
                    }
                });
                document.dispatchEvent(mapVisibleEvent);
                console.log('Map section is now visible - event dispatched');
            }
        },
    });

    gsap.from('.prize-item', {
        scrollTrigger: {
            trigger: ".prizes-container",
            start: "30% 70%",
            end: "80% 80%",
            scrub: 1,
        },
        opacity: 0,
        y: 50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });


    gsap.from('.how-to-win-cart', {
        scrollTrigger: {
            trigger: ".how-to-win-first-row",
            start: "0% 70%",
            end: "10% 70%",
            scrub: 1,
            markers: false,
        },
        opacity: 0,
        x: -50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });
    gsap.from('.how-to-win-first-row-line', {
        scrollTrigger: {
            trigger: ".how-to-win-first-row",
            start: "10% 70%",
            end: "50% 70%",
            scrub: 1,
            markers: false,
        },
        drawSVG: 0,
    });
    gsap.from('.how-to-win-first-row-text', {
        scrollTrigger: {
            trigger: ".how-to-win-first-row",
            start: "30% 70%",
            end: "40% 70%",
            scrub: 1,
            markers: false,
        },
        opacity: 0,
        y: 50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });
    gsap.from('.how-to-win-laptop', {
        scrollTrigger: {
            trigger: ".how-to-win-first-row",
            start: "40% 70%",
            end: "50% 70%",
            scrub: 1,
            markers: false,
        },
        opacity: 0,
        x: 50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });
    gsap.from('.how-to-win-pin', {
        scrollTrigger: {
            trigger: ".how-to-win-second-row",
            start: "0% 70%",
            end: "10% 70%",
            scrub: 1,
            markers: false,
        },
        opacity: 0,
        y: -50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });
    gsap.from('.how-to-win-second-row-line', {
        scrollTrigger: {
            trigger: ".how-to-win-second-row",
            start: "10% 70%",
            end: "50% 70%",
            scrub: 1,
            markers: false,
        },
        drawSVG: 0,
    });
    gsap.from('.how-to-win-second-row-text', {
        scrollTrigger: {
            trigger: ".how-to-win-second-row",
            start: "30% 70%",
            end: "40% 70%",
            scrub: 1,
            markers: false,
        },
        opacity: 0,
        y: 50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });
    gsap.from('.how-to-win-gift', {
        scrollTrigger: {
            trigger: ".how-to-win-second-row",
            start: "40% 70%",
            end: "50% 70%",
            scrub: 1,
            markers: false,
        },
        opacity: 0,
        x: 50,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out"
    });
});