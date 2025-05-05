document.addEventListener("DOMContentLoaded", function () {
  if (typeof gsap === "undefined") {
    console.error(
      "GSAP library is not loaded. Please include the GSAP script."
    );
    return;
  }
});

function openModal(index) {
    const modal = document.querySelector(`.prizes-details-modal[data-index="${index}"]`);
    const modalBox = modal.querySelector('.prizes-details-modal-box');

    document.body.style.overflow = "hidden";
    gsap.to(modal, {
        duration: 0.3,
        opacity: 1,
        display: "flex",
        ease: "power2.out",
    });
    gsap.to(modalBox, {
        duration: 0.3,
        y: 0,
        opacity: 1,
        ease: "power2.out",
    });
}

function closeModal() {
    const modals = document.querySelectorAll('.prizes-details-modal');

    document.body.style.overflow = "auto";
    modals.forEach(modal => {
        const modalBox = modal.querySelector('.prizes-details-modal-box');
        gsap.to(modalBox, {
            duration: 0.3,
            y: 50,
            opacity: 0,
            ease: "power2.out",
            onComplete: function() {
                gsap.to(modal, {
                    duration: 0.3,
                    opacity: 0,
                    display: "none",
                    ease: "power2.out",
                });
            }
        });
    });
}
