import React, { useState, useRef, useEffect } from "react";
import Form from "./Form";
import { ToastContainer, Bounce, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import Prize from "./Prize";

import gsap from "gsap";
import { useGSAP } from "@gsap/react";

function CampaignFormApp() {
  const campaignFormRef = useRef(null);
  const prizeRef = useRef(null);
  const transitionRef = useRef(null);

  const [banType, setBanType] = useState(null);
  const [isBanned, setIsBanned] = useState(false);
  const [entryId, setEntryId] = useState(null);
  const [showPrize, setShowPrize] = useState(false);
  const [prize, setPrize] = useState(null);

  useGSAP(() => {
    // Initially hide the prize section and transition element
    gsap.set(prizeRef.current, { autoAlpha: 0 }); // prizeRef also has inline display: 'none'
    gsap.set(transitionRef.current, { autoAlpha: 0, display: "none" }); // Explicitly hide transitionRef initially
  }, []);

  useEffect(() => {
    if (showPrize) {
      const tl = gsap.timeline();

      tl.to(transitionRef.current, {
        duration: 0.4,
        autoAlpha: 1,
        display: "block", // Ensure it's in the layout flow for animation
        scale: 1.4,
        ease: "power2.inOut",
      })
        .to(transitionRef.current, {
          duration: 0.4,
          autoAlpha: 0,
          scale: 1.2,
          ease: "power2.inOut",
          onComplete: () => {
            if (transitionRef.current) {
              // After fading out, set display: none to remove from layout
              transitionRef.current.style.display = "none";
            }
          },
        }) // Corrected: Removed extraneous comma that was here
        .to(
          campaignFormRef.current,
          {
            duration: 0.1,
            autoAlpha: 0,
            ease: "power2.inOut",
            onComplete: () => {
              // After fading out, set display: none to remove from layout
              if (campaignFormRef.current) {
                campaignFormRef.current.style.display = "none";
              }
            },
          },
          "-=0.6"
        )
        .to(
          prizeRef.current,
          {
            duration: 0.1,
            autoAlpha: 1,
            ease: "power2.inOut",
            onStart: () => {
              // Before fading in, ensure prizeRef is in the layout flow
              // This overrides the initial inline style display: 'none'
              if (prizeRef.current) {
                prizeRef.current.style.display = "block";
              }
            },
          },
          "-=0.2"
        );
    }
  }, [showPrize]);

  const sendPrizeEmail = async (email, prize) => {
    try {
      const formData = new FormData();
      formData.append('action', 'magura_send_email');
      formData.append('email', email);
      formData.append('prize', prize);
      formData.append('security', campaignData.security);

      const response = await fetch(campaignData.ajax_url, {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
    } catch (error) {
      console.error("Error sending prize email:", error);
    }
  };

  const handleEntrySubmit = async (formData) => {
    const formDataToSend = new FormData();
    Object.entries(formData).forEach(([key, value]) => {
      if (value) {
        // Special handling for File objects
        if (value instanceof File) {
          formDataToSend.append(key, value, value.name);
        } else {
          formDataToSend.append(key, value);
        }
      }
    });

    try {
      const response = await fetch(`${campaignData.api_url}campaign/submit`, {
        method: "POST",
        headers: {
          // "X-api-token": campaignData.api_token,
          Accept: "application/json",
        },
        body: formDataToSend,
      });

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const data = await response.json();
      if (data?.status === "success") {
        setEntryId(data.entry_id);
        if (data.type === "winner") {
          setPrize(data.prize);
          setShowPrize(true);
          await sendPrizeEmail(formData.email, data.prize);
          return true;
        } else {
          setPrize(null);
          setShowPrize(true);
          setIsBanned(false);
          setBanType(null);
          return true;
        }
      } else if (data?.status === "banned") {
        setPrize(null);
        setShowPrize(true);
        setIsBanned(true);
        setBanType(data.type);
        return true;
      }
      throw new Error("If statements passed", data);
    } catch (error) {
      console.error("Error submitting form:", error);
      toast.error("A apărut o eroare. Te rugăm să încerci din nou mai târziu.");
      return false;
    }
  };

  return (
    <div className="campaign-form-container">
      <div ref={campaignFormRef}>
        <Form handleEntrySubmit={handleEntrySubmit} />
      </div>
      <div className="campaign-transition" ref={transitionRef}>
        <img src={campaignData.transition_img} />
      </div>
      <div ref={prizeRef} style={{ display: "none" }}>
        {" "}
        {/* Initially hide with style */}
        <Prize prize={prize} entry_id={entryId} is_banned={isBanned} ban_type={banType} />{" "}
        {/* Pass prize data to Prize component */}
      </div>

      <ToastContainer
        position="bottom-right"
        autoClose={5000}
        hideProgressBar={false}
        newestOnTop
        closeOnClick={false}
        rtl={false}
        pauseOnFocusLoss
        draggable
        pauseOnHover
        theme="colored"
        transition={Bounce}
        // stacked
      />
    </div>
  );
}

export default CampaignFormApp;
