import React, { useState } from "react";
import propTypes from "prop-types";
import "Shared/common-styles/space.css";
import "Shared/common-styles/common.css";

export const emailValidation = (value) => {
  let error = null;
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
  if (!value) {
    error = "Email is required";
  } else if (!regex.test(value)) {
    error = "Email is not valid!";
  }
  return error;
};

const Email = ({ name, formErrors, onInput, value }) => {
  const [fieldsTouched, setFieldsTouched] = useState(false);

  const handleFocus = (e) => {
    setFieldsTouched(true);
  };
  const handleInput = (e) => {
    setFieldsTouched(true);
    onInput?.(e);
  };

  return (
    <>
      <div className="form-group">
        <div>
          <label className="cd-mt-12 cd-lable-signup">Email</label>
          <input
            type="email"
            className="form-control cd-mt-8"
            name={name}
            placeholder="Enter your Email address"
            defaultValue={value}
            onBlur={handleFocus}
            onInput={handleInput}
          />
          {fieldsTouched && formErrors && (
            <p className="text-danger">{formErrors[name]}</p>
          )}
        </div>
      </div>
    </>
  );
};
Email.defaultProps = {
  formErrors: {},
};
Email.propTypes = {
  label: propTypes.string,
  onInput: propTypes.func,
  formErrors: propTypes.object,
  name: propTypes.string,
  email: propTypes.string,
};
export default Email;
