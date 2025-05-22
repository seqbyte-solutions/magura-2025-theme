import React, { useEffect, useRef, useState } from "react";

function Autocomplete({
  name,
  id,
  value,
  placeholder,
  onChange,
  options,
  required,
  error,
  disabled = false, 
}) {
    const autocompleteRef = useRef(null);
  const [isOpen, setIsOpen] = useState(false);
  const [searchValue, setSearchValue] = useState("");

  const [filteredOptions, setFilteredOptions] = useState([...options]);

  useEffect(() => {
    if (searchValue !== "") {
      const normalize = (str) =>
        str
          .normalize("NFD")
          .replace(/[\u0300-\u036f]/g, "")
          .toLowerCase();
      const filtered = options.filter((option) =>
        normalize(option.label).includes(normalize(searchValue))
      );
      setFilteredOptions(filtered);
    } else {
      setFilteredOptions(options);
    }
  }, [searchValue, options]);

  const handleSelectOption = (e) => {
    onChange(e);
    setSearchValue("");
    setIsOpen(false);
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
       if (autocompleteRef.current && !autocompleteRef.current.contains(event.target)) {
        setIsOpen(false);
      }
    };
    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, []);

  return (
    <div ref={autocompleteRef}>
      <button className="autocomplete-trigger" type="button" onClick={() => setIsOpen(true)} disabled={disabled}>
        <input type="text" value={value ? value : placeholder} readOnly />
       
      </button>

      {isOpen && (
        <div className="autocomplete-options-container">
          <div className="autocomplete-search-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" className="autocomplete-search-icon"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>

            <input
              type="text"
              className="autocomplete-search"
              value={searchValue}
              onChange={(e) => {
                setSearchValue(e.target.value);
              }}
            />
          </div>
          <div className="autocomplete-options">
            {filteredOptions.length === 0 ? <>
                <p>Nu există opțiuni</p>
            </> : <>
                {filteredOptions.map((option, index) => (
                  <div key={index} className="autocomplete-option">
                    <button
                      onClick={handleSelectOption}
                      type="button"
                      name={name}
                      value={option.value}
                    >
                      {option.label}
                    </button>
                  </div>
                ))}
            </>}
          </div>
        </div>
      )}
    </div>
  );
}

export default Autocomplete;
