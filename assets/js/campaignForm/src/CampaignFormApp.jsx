import React from 'react'
import Form from './Form'
import { ToastContainer, Bounce } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'

function CampaignFormApp() {

  const handleEntrySubmit = async (formData) => {
    
  }

  return (
    <div>
        <Form handleEntrySubmit={
          handleEntrySubmit
        } />
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
  )
}

export default CampaignFormApp