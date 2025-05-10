document.addEventListener("DOMContentLoaded", function () {
  // Check if GSAP is loaded
  if (typeof gsap === "undefined") {
    console.error(
      "GSAP library is not loaded. Please include the GSAP script."
    );
    return;
  }

  const headingTl = gsap.timeline();
  headingTl
    .to("#headliner-text-castiga", {
      duration: 0.3,
      opacity: 1,
      y: 0,
      ease: "power2.out",
      delay: 0.4,
    })
    .to("#headliner-text-cu", {
      duration: 0.2,
      scaleX: 1,
      opacity: 1,
      x: 0,
      transformOrigin: "left",
      ease: "power2.out",
    })
    .to("#headliner-logo", {
      opacity: 1,
      duration: 0.2,
      ease: "power2.out",
    })
    .to(
      "#headliner-text-dintr-o",
      {
        opacity: 1,
        duration: 0.3,
        scaleY: 1,
        y: 0,
        rotateX: 0,
        transformOrigin: "top",
        ease: "power2.out",
      },
      "=+0.1"
    )
    .to("#headliner-text-imbratisare", {
      opacity: 1,
      duration: 0.3,
      y: 0,
      transformOrigin: "top",
      ease: "power2.out",
    })
    .to(".hero-cta", {
      y: 0,
      opacity: 1,
      delay: 0.2,
      duration: 0.2,
      ease: "power2.out",
    }).to(
      ".hero-scrolldown-btn",{
        y: 0,
        opacity: 1,
        delay: 0.1,
        duration: 0.2,
        ease: "power2.out",
      }).to('.initial-arrow',{
        duration: 0.4,
        stagger: -0.1,
        y: 0,
        onComplete: function () {
            let animationIsRunning = false;
            document
              .getElementById("hero-scrolldown-btn")
              .addEventListener("mouseover", function () {
                const arrowsTl = gsap.timeline();
                if(animationIsRunning) return; 
                animationIsRunning = true;
                arrowsTl
                  .to(".initial-arrow", {
                    duration: 0.4,
                    stagger: -0.1,
                    y: 50,
                  })
                  .to(".clone-arrow", {
                    duration: 0.4,
                    stagger: -0.1,
                    y: 0,
                  })
                  .to(".initial-arrow", {
                    duration: 0,
                    y: 0,
                    
                  },"+=0.2")
                  .to(".clone-arrow", {
                    duration: 0,
                    y: -50,
                    onComplete: function () {
                      animationIsRunning = false; // Reset the flag when the animation is complete
                    },
                  });
              });
        }
      });

  gsap.registerPlugin(ScrollTrigger);
  gsap.registerPlugin(DrawSVGPlugin);

  gsap.to(".magura-map-container", {
    scrollTrigger: {
      trigger: ".magura-map-section",
      start: "0% center",
      end: "25% center",
      scrub: 1,
      // markers: true
    },
    opacity: 1,
    y: 0,
  });

  gsap.from(".prize-item", {
    scrollTrigger: {
      trigger: ".prizes-container",
      start: "30% 70%",
      end: "50% 60%",
      scrub: 1,
    },
    opacity: 0,
    y: 50,
    duration: 0.6,
    stagger: 0.2,
    ease: "power2.out",
  });

  gsap.from(".how-to-win-cart", {
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
    ease: "power2.out",
  });
  gsap.from(".how-to-win-first-row-line", {
    scrollTrigger: {
      trigger: ".how-to-win-first-row",
      start: "10% 70%",
      end: "50% 70%",
      scrub: 1,
      markers: false,
    },
    drawSVG: 0,
  });
  gsap.from(".how-to-win-first-row-text", {
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
    ease: "power2.out",
  });
  gsap.from(".how-to-win-laptop", {
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
    ease: "power2.out",
  });
  gsap.from(".how-to-win-pin", {
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
    ease: "power2.out",
  });
  gsap.from(".how-to-win-second-row-line", {
    scrollTrigger: {
      trigger: ".how-to-win-second-row",
      start: "10% 70%",
      end: "50% 70%",
      scrub: 1,
      markers: false,
    },
    drawSVG: 0,
  });
  gsap.from(".how-to-win-second-row-text", {
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
    ease: "power2.out",
  });
  gsap.from(".how-to-win-gift", {
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
    ease: "power2.out",
  });

  
 
});
