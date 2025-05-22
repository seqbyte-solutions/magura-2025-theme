import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import ValidateFormApp from './ValidateFormApp.jsx'

createRoot(document.getElementById('validate-form-app')).render(
  <StrictMode>
    <ValidateFormApp api_url={validateData?.api_url} validation_data={validateData?.validationData} entry_data={validateData?.entryData}  entry_id={validateData?.entryId} />
  </StrictMode>,
)
