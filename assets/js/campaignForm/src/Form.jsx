import React, { useEffect, useState } from "react";
import Autocomplete from "./Autocomplete";

function Form() {
  const counties = [{ label: "Alba", value: "AB" }];

  const localities = {
    AB: [
      { label: "Alba Iulia", value: "AB" },
      { label: "Aiud", value: "AI" },
      { label: "Cugir", value: "CU" },
      { label: "Ocna Mureș", value: "OM" },
      { label: "Sebeș", value: "SE" },
      { label: "Teiuș", value: "TE" },
    ],
  };

  const [formData, setFormData] = useState({
    last_name: "",
    first_name: "",
    email: "",
    phone: "",
    county: "",
    locality: "",
    reciep_image: null,
  });

  useEffect(() => {
    console.log("Form data changed:", formData);
  }, [formData]);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {};
  return (
    <div>
      <form onSubmit={handleSubmit}>
        <div className="form-content">
          <div className="form-input-container">
            <label htmlFor="form_field_last_name">Nume</label>
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
            <label htmlFor="form_field_first_name">Prenume</label>
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
            <label htmlFor="form_field_email">Adresa de email</label>
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
            <label htmlFor="form_field_phone">Număr de telefon</label>
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
            <label htmlFor="form_field_county">Județ</label>
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
            <label htmlFor="form_field_locality">Localitate</label>
            <Autocomplete
              id="form_field_locality"
              value={formData.locality}
              name="locality"
              placeholder={"Selectează o localitate"}
              onChange={handleInputChange}
              options={
                formData.county !== "" ? localities[formData.county] : []
              }
              disabled={formData.county === ""}
            />
          </div>

          <div className="form-attachment-container"></div>

          <div className="form-checkbox-container">
            <label>
              <input type="checkbox" name="" /> Sunt de acord cu Termenii și
              Condițiile campaniei
            </label>
          </div>

          <div className="form-submit-container">
            <button>Trimite</button>
          </div>
        </div>
      </form>
    </div>
  );
}

export default Form;
