import React, { useState } from "react";
import propTypes from "prop-types";
import "Shared/common-styles/space.css";
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

const Email = ({ name, formErrors, onInput }) => {
  const initialValues = {
    email: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [fieldsTouched, setFieldsTouched] = useState(false);

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };
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
          <label className="cd-mt-12">Email</label>
          <input
            type="email"
            className="form-control cd-mt-8"
            name={name}
            placeholder="Enter your Email address"
            onChange={handleChanges}
            defaultValue={formValues.email}
            onBlur={handleFocus}
            onInput={handleInput}
          />
          {fieldsTouched && <p className="text-danger">{formErrors[name]}</p>}
        </div>
      </div>
    </>
  );
};
Email.propTypes = {
  label: propTypes.string,
};
export default Email;
