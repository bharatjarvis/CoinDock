import React, { useState } from "react";
import propTypes from "prop-types";
import "Shared/common-styles/space.css";
import "Shared/common-styles/common.css";
export const nameValidation = (value, label = "Name", length = 0) => {
  let error = null;

  if (!value) {
    error = `${label} is required`;
  } else if (value.length > 45) {
    error = ` The ${label} may not be greater than ${length} characters.`;
  }
  return error;
};

const Name = ({
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

Name.propTypes = {
  label: propTypes.string,

  name: propTypes.string,
  placeholder: propTypes.string,
  formErrors: propTypes.object,
  onInput: propTypes.func,
  currentFieldValue: propTypes.string,
};
export default Name;
