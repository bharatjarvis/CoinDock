import React, { useState } from "react";
import propTypes from "prop-types";
import "Shared/common-styles/space.css";
import "Shared/common-styles/common.css";
export const walletnameValidation = (value, label = "Name", length = 0) => {
  let error = null;

  if (!value) {
    error = `${label} is required`;
  }
  return error;
};

const WalletName = ({
  label,
  name,
  placeholder,
  formErrors,
  onInput,
  currentFieldValue,
}) => {
  const [fieldsTouched, setFieldsTouched] = useState(false);

  const handleFocus = (e) => {
    setFieldsTouched(true);
  };
  const handleInput = (e) => {
    setFieldsTouched(true);
    onInput?.(e);
  };

  return (
    <div className="form-group">
      <div>
        <label className="cd-mt-12 cd-lable-signup">{label}</label>
        <input
          type="text"
          className="form-control cd-mt-8"
          name={name}
          placeholder={placeholder}
          defaultValue={currentFieldValue}
          onBlur={handleFocus}
          onInput={handleInput}
        />
      </div>
      {formErrors && fieldsTouched && (
        <p className="text-danger">{formErrors[name]}</p>
      )}
    </div>
  );
};

WalletName.propTypes = {
  label: propTypes.string,
};
export default WalletName;
