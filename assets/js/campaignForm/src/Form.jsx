import React, { useEffect, useState } from "react";
import Autocomplete from "./Autocomplete";
import AttachmentInput from "./AttachmentInput";
import countiesAndCities from "./counties-and-cities.json";
import { toast } from "react-toastify";

function Form({handleEntrySubmit}) {
  const counties = countiesAndCities.map((county) => ({
    label: county.nume,
    value: county.nume,
  }));

  const localities = countiesAndCities.reduce((acc, county) => {
    const countyName = county.nume;
    const cities = county.localitati.map((city) => ({
      label: city,
      value: city,
    }));
    acc[countyName] = cities;
    return acc;
  }, {});

  const [formSubmitIsLoading, setFormSubmitIsLoading] = useState(false);
  const [formData, setFormData] = useState({
    last_name: "",
    first_name: "",
    email: "",
    phone: "",
    county: "",
    locality: "",
    reciep_number: "",
    reciep_image: null,
    tc: false,
  });
  const [formErrors, setFormErrors] = useState({
    last_name: false,
    first_name: false,
    email: false,
    phone: false,
    county: false,
    locality: false,
    reciep_number: false,
    reciep_image: false,
    tc: false,
  });

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target;
    if (type === "checkbox") {
      setFormData((prevData) => ({
        ...prevData,
        [name]: checked,
      }));
    } else {
      setFormData((prevData) => ({
        ...prevData,
        [name]: value,
      }));
      if(name === "county") {
        setFormData((prevData) => ({
          ...prevData,
          locality: "",
        }));
      }
    }
    setFormErrors((prevData) => ({
      ...prevData,
      [name]: false,
    }));
  };

  const handleFileInputChange = (file, name) => {
    setFormData((prevData) => ({
      ...prevData,
      [name]: file,
    }));
    setFormErrors((prevData) => ({
      ...prevData,
      [name]: false,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setFormSubmitIsLoading(true);

    let formIsValid = true;
    for (const key in formData) {
      if (formData[key] === "") {
        setFormErrors((prevData) => ({
          ...prevData,
          [key]: true,
        }));
        formIsValid = false;
      }
    }

    if (formData.reciep_image === null) {
      // toast.error("Vă rugăm să atașați o imagine a bonului fiscal.");
      setFormErrors((prevData) => ({
        ...prevData,
        reciep_image: true,
      }));
      formIsValid = false;
    }
    if (!formData.tc) {
      // toast.error("Vă rugăm să bifați acordul regulamentului.");
      setFormErrors((prevData) => ({
        ...prevData,
        tc: true,
      }));
      formIsValid = false;
    }
    if (!formIsValid) {
      toast.error("Vă rugăm să completați toate câmpurile.");
      setFormSubmitIsLoading(false);
      return;
    }

    const response = await handleEntrySubmit(formData);
     
    setFormSubmitIsLoading(false);
  };
  return (
    <div>
      <form onSubmit={handleSubmit}>
        <div className="form-content">
          <div className="form-input-container">
            <label
              htmlFor="form_field_last_name"
              className={`${formErrors.last_name && "error"}`}
            >
              Nume
            </label>
            <input
              type="text"
              name="last_name"
              id="form_field_last_name"
              value={formData.last_name}
              onChange={handleInputChange}
              required
            />
          </div>
          <div className="form-input-container">
            <label
              className={`${formErrors.first_name && "error"}`}
              htmlFor="form_field_first_name"
            >
              Prenume
            </label>
            <input
              type="text"
              name="first_name"
              id="form_field_first_name"
              value={formData.first_name}
              onChange={handleInputChange}
              required
            />
          </div>
          <div className="form-input-container">
            <label
              className={`${formErrors.email && "error"}`}
              htmlFor="form_field_email"
            >
              Adresa de email
            </label>
            <input
              type="email"
              name="email"
              id="form_field_email"
              value={formData.email}
              onChange={handleInputChange}
              required
            />
          </div>
          <div className="form-input-container">
            <label
              className={`${formErrors.phone && "error"}`}
              htmlFor="form_field_phone"
            >
              Număr de telefon
            </label>
            <input
              type="tel"
              name="phone"
              id="form_field_phone"
              value={formData.phone}
              onChange={handleInputChange}
              required
            />
          </div>
          <div className="form-input-container">
            <label
              className={`${formErrors.county && "error"}`}
              htmlFor="form_field_county"
            >
              Județ
            </label>
            <Autocomplete
              id="form_field_county"
              value={formData.county}
              name="county"
              placeholder={"Selectează un județ"}
              onChange={handleInputChange}
              options={counties}
            />
          </div>
          <div className="form-input-container">
            <label
              className={`${formErrors.locality && "error"}`}
              htmlFor="form_field_locality"
            >
              Localitate
            </label>
            <Autocomplete
              id="form_field_locality"
              value={formData.locality}
              name="locality"
              placeholder={"Selectează o localitate"}
              onChange={handleInputChange}
              options={
                formData.county !== "" ? [...localities[formData.county]] : []
              }
              disabled={formData.county === ""}
            />
          </div>

          <div className="form-input-container">
            <label
              className={`${formErrors.reciep_number && "error"}`}
              htmlFor="form_field_reciep_number"
            >
              Numărul bonului fiscal
            </label>
            <input
              type="text"
              name="reciep_number"
              id="form_field_reciep_number"
              value={formData.reciep_number}
              onChange={handleInputChange}
              required
            />
          </div>

          <div className="form-attachment-container">
            <label className={`${formErrors.reciep_image && "error"}`}>
              Poza bonului fiscal
            </label>
            <AttachmentInput
              name="reciep_image"
              value={formData.reciep_image}
              onChange={handleFileInputChange}
            />
          </div>

          <div className="form-checkbox-container">
            <label className={`${formErrors.tc && "error"}`}>
              <div className="checkbox-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                </svg>
              </div>
              <input
                type="checkbox"
                name="tc"
                checked={formData.tc}
                onChange={handleInputChange}
              />
              &nbsp;&nbsp;Sunt de acord cu{" "}
              <a href="/concurs/regulament/" target="_blank">
                regulamentul
              </a>{" "}
              campaniei și cu reglementările <a href="https://gdpr-info.eu/" target="_blank">GDPR</a>
              
                
              
            </label>
          </div>

          <div className="form-submit-container">
            <button disabled={formSubmitIsLoading}>
              {formSubmitIsLoading ? <>Se încarcă</> : <>Trimite</>}
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}

export default Form;
