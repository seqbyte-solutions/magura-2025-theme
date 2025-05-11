import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import CampaignFormApp from './CampaignFormApp'

createRoot(document.getElementById('campaign-form-app')).render(
  <StrictMode>
    <CampaignFormApp />
  </StrictMode>,
)
