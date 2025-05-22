import React, { useState } from "react";
import Autocomplete from "./Autocomplete";
import countiesAndCities from "./counties-and-cities.json";
import { toast } from "react-toastify";
import { ToastContainer, Bounce } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function ValidateFormApp({ api_url, validation_data, entry_data, entry_id }) {
  const [formSubmitSuccess, setFormSubmitSuccess] = useState(false);  

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
    last_name: entry_data.last_name,
    first_name: entry_data.first_name,
    email: entry_data.email,
    phone: entry_data.phone,
    cnp: "",
    county: "",
    locality: "",
    address: "",
    postal_code: "",
  });
  const [formErrors, setFormErrors] = useState({
    county: false,
    locality: false,
    cnp: false,
    address: false,
    postal_code: false,
  });

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target;
    if (name === "cnp") {
      if (value.length > 13) {
        setFormErrors((prevData) => ({
          ...prevData,
          cnp: true,
        }));
      } else if (value.length < 13) {
        setFormErrors((prevData) => ({
          ...prevData,
          cnp: true,
        }));
      } else {
        setFormErrors((prevData) => ({
          ...prevData,
          cnp: false,
        }));
      }

      if (isNaN(value)) {
        setFormErrors((prevData) => ({
          ...prevData,
          cnp: true,
        }));
        return;
      }

      setFormData((prevData) => ({
        ...prevData,
        cnp: value,
      }));

      return;
    }
    if (name === "postal_code") {
      if (value.length > 6) {
        setFormErrors((prevData) => ({
          ...prevData,
          postal_code: true,
        }));
      } else if (value.length < 6) {
        setFormErrors((prevData) => ({
          ...prevData,
          postal_code: true,
        }));
      } else {
        setFormErrors((prevData) => ({
          ...prevData,
          postal_code: false,
        }));
      }

      if (isNaN(value)) {
        setFormErrors((prevData) => ({
          ...prevData,
          postal_code: true,
        }));
        return;
      }

      setFormData((prevData) => ({
        ...prevData,
        postal_code: value,
      }));

      return;
    }
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
    if (!formIsValid) {
      toast.error("Vă rugăm să completați toate câmpurile.");
      setFormSubmitIsLoading(false);
      return;
    }

    const bodyData = new FormData();
    Object.entries(formData).forEach(([key, value]) => {
      if (value) {
        bodyData.append(key, value);
      }
    });
    bodyData.append("entry_id", entry_id);

    try {
      const response = await fetch(
        `${api_url}campaign/entries/validate/submit`,
        {
          method: "POST",
          headers: {
            Accept: "application/json",
          },
          body: bodyData,
        }
      );
      if (response.ok) {
        const data = await response.json();
        if (data?.status === "success") {
          toast.success("Formularul a fost trimis cu succes.");
          setFormSubmitSuccess(true);
        } else {
          toast.error("A apărut o eroare. Vă rugăm să încercați din nou.");
        }
      }
    } catch (error) {
      console.error("Error submitting form:", error);
      toast.error("A apărut o eroare. Vă rugăm să încercați din nou.");
    } finally {
      setFormSubmitIsLoading(false);
    }
  };

  return (
    <div>
      {formSubmitSuccess ? <>
        <div className="prize-content">
          <h2 className="prize-title">Felicitări!</h2>
          <p className="prize-desc">
              Înscrierea dvs. câștigătoare a fost validată cu succes.
            </p>
          <p className="prize-desc">
              Veți intra în posesia premiului în cel mai scurt timp.
            </p>
            <br/>
             <a href="/">Înapoi acasă</a>
        </div>
      </> : <>
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
              readonly
              disabled
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
              readonly
              disabled
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
              readonly
              disabled
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
              readonly
              disabled
            />
          </div>
          <div className="form-input-container">
            <label
              className={`${formErrors.cnp && "error"}`}
              htmlFor="form_field_cnp"
            >
              CNP
            </label>
            <input
              type="text"
              name="cnp"
              id="form_field_cnp"
              value={formData.cnp}
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
              className={`${formErrors.address && "error"}`}
              htmlFor="form_field_address"
            >
              Adresa de livrare
            </label>
            <input
              type="text"
              name="address"
              id="form_field_address"
              value={formData.address}
              onChange={handleInputChange}
              required
            />
          </div>

          <div className="form-input-container">
            <label
              className={`${formErrors.postal_code && "error"}`}
              htmlFor="form_field_postal_code"
            >
              Cod poștal
            </label>
            <input
              type="text"
              name="postal_code"
              id="form_field_postal_code"
              value={formData.postal_code}
              onChange={handleInputChange}
              required
            />
          </div>

          <div className="form-submit-container">
            <button disabled={formSubmitIsLoading}>
              {formSubmitIsLoading ? <>Se încarcă</> : <>Trimite</>}
            </button>
          </div>
        </div>
      </form>
      </>}
      
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

export default ValidateFormApp;
