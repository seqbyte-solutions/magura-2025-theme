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

  const [showPrize, setShowPrize] = useState(false);
  const [prize, setPrize] = useState(null);

  const {contextSafe} = useGSAP();


  const handleEntrySubmit = async (formData) => {
    const formDataToSend = new FormData();
    console.log("Form data to send:", formData);  
    setShowPrize(true);
    contextSafe(() => {
    
      console.log("showPrize is true");
      gsap.fromTo(prizeRef.current, { opacity: 0 }, { opacity: 1, duration: 1 });
      gsap.fromTo(campaignFormRef.current, { opacity: 1 }, { opacity: 0, duration: 1 });
    
  })
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
        setShowPrize(true);
        setPrize(data.prize);
      }
      console.log("Form submitted successfully:", data);
    } catch (error) {
      console.error("Error submitting form:", error);
    }
  };



  return (
    <div>
      <div ref={campaignFormRef}>
      <Form handleEntrySubmit={handleEntrySubmit} />
      </div>
      <div ref={prizeRef}>
      <Prize />
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
