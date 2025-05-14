import React, {useState, useRef, useEffect} from "react";
import Form from "./Form";
import { ToastContainer, Bounce } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import Prize from "./Prize";

import gsap from 'gsap';
import { useGSAP } from '@gsap/react';

function CampaignFormApp() {
  const campaignFormRef = useRef(null);
  const prizeRef = useRef(null);
  const transitionRef = useRef(null);

  const [showPrize, setShowPrize] = useState(false);
  const [prize, setPrize] = useState(null);

  useGSAP(() => {
    // Initially hide the prize section
    gsap.set(prizeRef.current, { autoAlpha: 0 });
  }, []);

  useEffect(() => {
    if (showPrize) {
      const tl = gsap.timeline();

      tl.to(transitionRef.current, {
        duration: 0.4,
        autoAlpha: 1,
        display: 'block',
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
            transitionRef.current.style.display = 'none';
          }
        }
      }, ).to(campaignFormRef.current, { 
        duration: 0.1, 
        autoAlpha: 0, 
        ease: "power2.inOut",
        onComplete: () => {
          // Optionally hide the form completely or set display: none
          if (campaignFormRef.current) {
            campaignFormRef.current.style.display = 'none';
          }
        }
      }, "-=0.6").to(prizeRef.current, { 
        duration: 0.1, 
        autoAlpha: 1, 
        ease: "power2.inOut",
        onStart: () => {
            // Ensure prizeRef is visible for animation
            if (prizeRef.current) {
                prizeRef.current.style.display = 'block'; 
            }
        }
      }, "-=0.2")
     ;
    }
  }, [showPrize]);

  const handleEntrySubmit = async (formData) => {
    const formDataToSend = new FormData();
    console.log("Form data to send:", formData); 
     setShowPrize(true);
     
    //  select random number between 0 and 5
    const randomNumber = Math.floor(Math.random() * 6);
    const prizes = [
      'vacanta',
      'set magura',
      'rucsac visiniu',
      'rucsac bej',
      'rucsac model fluturi'
    ]
    if(randomNumber === 0){
      setPrize(null);
    } else {
      setPrize(prizes[randomNumber]);
    }

     return;
    Object.entries(formData).forEach(([key, value]) => {
      if (value) {
        formDataToSend.append(key, value);
      }
    });

    try {
      const response = await fetch(
        campaignData.api_url,
        {
          method: "POST",
          headers: {
            "X-api-token": campaignData.api_token,
            "Accept": "application/json",
          },
          body: formDataToSend,
        }
      );

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const data = await response.json();
      if(data.status === "success") {
        setPrize(data.prize); // Set prize data first
        setShowPrize(true); // Then trigger the animation
      }
      console.log("Form submitted successfully:", data);
    } catch (error) {
      console.error("Error submitting form:", error);
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
      <div ref={prizeRef} style={{ display: 'none' }}> {/* Initially hide with style */}
        <Prize 
        prize={prize} 
        /> {/* Pass prize data to Prize component */}
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
        stacked
      />
    </div>
  );
}

export default CampaignFormApp;
