import React, { useRef, useState, useEffect } from "react";
import { toast } from "react-toastify";

function AttachmentInput({ name, onChange, value }) {
  const fileInputRef = useRef(null);
  const dropzoneImagePreview = useRef(null);

  const [isDropzoneOverlayVisible, setIsDropzoneOverlayVisible] =
    useState(false);

  const handleOpenFileUploader = (e) => {
    e.preventDefault();
    fileInputRef.current.click();
  };

  const handleDragEnter = (event) => {
    event.preventDefault();
    setIsDropzoneOverlayVisible(true);
  };

  const handleDragLeave = (event) => {
    event.preventDefault();
    setIsDropzoneOverlayVisible(false);
  };

  const handleDragOver = (event) => {
    event.preventDefault();
  };

  const handleDrop = (event) => {
    event.preventDefault();
    setIsDropzoneOverlayVisible(false);
    const file = event.dataTransfer.files[0];

    // Check if file exists
    if (!file) return;

    // Check file type
    if (!file.type.match(/image\/(jpeg|jpg|png|bmp|webp)/i)) {
      toast.error(
        "Vă rugăm să atașați doar imagini în format PNG, JPG, JPEG, BMP sau WEBP."
      );
      return;
    }

    // Check file size (6MB = 6 * 1024 * 1024 bytes)
    if (file.size > 6 * 1024 * 1024) {
      toast.error("Imaginea depășește dimensiunea maximă de 6MB.");
      return;
    }

    onChange(file, name);
  reader.readAsDataURL(file);
  };

  handleInputChange = (e) => {
    e.preventDefault();
    const file = e.target.files[0];

    // Check if file exists
    if (!file) return;

    // Check file type
    if (!file.type.match(/image\/(jpeg|jpg|png|bmp|webp)/i)) {
      toast.error(
        "Vă rugăm să atașați doar imagini în format PNG, JPG, JPEG, BMP sau WEBP."
      );
      return;
    }

    // Check file size (6MB = 6 * 1024 * 1024 bytes)
    if (file.size > 6 * 1024 * 1024) {
      toast.error("Imaginea depășește dimensiunea maximă de 6MB.");
      return;
    }

    onChange(file, name);
    reader.readAsDataURL(file);
    
  }

  const removeAttachedFile = (e) => {
    e.preventDefault();
    e.stopPropagation();
    onChange(null, name);
    fileInputRef.current.value = "";
    if (dropzoneImagePreview.current) {
      dropzoneImagePreview.current.src = "";
    }
  };

  const reader = new FileReader();
  reader.onload = (e) => {
    dropzoneImagePreview.current.src = e.target.result;
  };

  useEffect(() => {
    console.log("value", value);
  
  }, [value])
  
  return (
    <>
      <div
        className="form-image-dropzone"
        onClick={handleOpenFileUploader}
        onDragEnter={handleDragEnter}
        onDragLeave={handleDragLeave}
        onDragOver={handleDragOver}
        onDrop={handleDrop}
      >
        <div
          className={`form-image-dropzone-overlay ${
            isDropzoneOverlayVisible ? "is-visible" : ""
          }`}
        ></div>
        {value !== null ? (
          <>
            <p>Trageți fișierul aici sau faceți clic pentru a-l atașa</p>
            <div className="form-image-dropzone-preview">
              <button
                className="form-image-dropzone-remove"
                onClick={removeAttachedFile}
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
              </button>
              <img ref={dropzoneImagePreview} src={value} />
            </div>
          </>
        ) : (
          <>
            <p>Trageți fișierul aici sau faceți clic pentru a-l atașa</p>
            <div className="form-image-dropzone-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 96C0 60.7 28.7 32 64 32l384 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6l96 0 32 0 208 0c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>
            </div>
          </>
        )}
        <p>Dimensiunea maximă este 6MB.</p>
      </div>
      <input
        type="file"
        name="image"
        onChange={handleInputChange}
        ref={fileInputRef}
        accept="image/.png,.jpg,.jpeg,.bmp,.webp"
      />
    </>
  );
}

export default AttachmentInput;
