import React, { useState } from "react";
import "Shared/common-styles/space.css";
export const passwordValidation = ({
  value,
  label = "Password",
  minlength = 12,
  maxlength = 45,
}) => {
  let error = null;
  const specialChar = /[!@#$%^&*]/;
  const number = /[0-9]/;
  const alpha = /[A-Za-z]/;
  if (!value) {
    error = `${label} is required`;
  } else if (value.length < 12) {
    error = `${label} should be more than ${minlength} characters`;
  } else if (!specialChar.test(value)) {
    error = "Password must contain at least one special character";
  } else if (!number.test(value)) {
    error = " Password must contain at least one number";
  } else if (!alpha.test(value)) {
    error = " Your password must include at least one letter.";
  } else if (value.length > maxlength) {
    error = `Password must be at most ${maxlength} characters`;
  }
  return error;
};

export const reenterpasswordValidation = (
  value,
  label = "Password",
  passwordValue
) => {
  let error = null;
  if (!value) {
    error = `Re-enter ${label} is required`;
  } else if (value !== passwordValue) {
    error = `${label}s are not matching`;
  }
  return error;
};

const Password = ({ name, placeholder, label, formErrors }) => {
  const initialValues = {
    password: "",
    reenterpassword: "",
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

  return (
    <>
      <div className="form-group">
        <div>
          <label className="cd-mt-12">{label}</label>
          <input
            type="password"
            className="form-control cd-mt-8"
            name={name}
            placeholder={placeholder}
            onChange={handleChanges}
            defaultValue={formValues.name}
            onBlur={handleFocus}
          />
          {fieldsTouched && <p className="text-danger">{formErrors[name]}</p>}
        </div>
      </div>
    </>
  );
};
export default Password;
