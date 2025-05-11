import React, { useRef, useState } from 'react'

function AttachmentInput() {
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
      toast.error("Vă rugăm să atașați doar imagini în format PNG, JPG, JPEG, BMP sau WEBP.");
      return;
    }
    
    // Check file size (6MB = 6 * 1024 * 1024 bytes)
    if (file.size > 6 * 1024 * 1024) {
      toast.error("Imaginea depășește dimensiunea maximă de 6MB.");
      return;
    }
    
    setFormInputs({
      ...formInputs,
      image: file,
    });
    
    const reader = new FileReader();
    reader.onload = (e) => {
      dropzoneImagePreview.current.src = e.target.result;
    };
    reader.readAsDataURL(file);
  };
  return (
    <><div
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
              {formInputs.image !== null ? (
                <>
                  <p>Trageți fișierul aici sau faceți clic pentru a-l atașa</p>
                  <div className="form-image-dropzone-preview">
                    <button
                      className="form-image-dropzone-remove"
                      onClick={removeAttachedFile}
                    >
                      <FaXmark />
                    </button>
                    <img ref={dropzoneImagePreview} />
                  </div>
                </>
              ) : (
                <>
                  <p>Trageți fișierul aici sau faceți clic pentru a-l atașa</p>
                  <div className="form-image-dropzone-icon">
                    <FaImage />
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
            /></>
  )
}

export default AttachmentInput