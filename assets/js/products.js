document.addEventListener("DOMContentLoaded", function () {
    if (typeof gsap === 'undefined') {
        console.error('GSAP library is not loaded. Please include the GSAP script.');
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    gsap.from("", {

    });
});