document.addEventListener("DOMContentLoaded", function () {
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
    })
});