import React, { useState } from "react";
export const passwordValidation = (value, label = "Password", length = 12) => {
  let error = null;

  if (!value) {
    error = `${label} is required`;
  } else if (value.length < 12) {
    error = `${label} should be more than ${length} characters`;
  }
  return error;
};

export const reenterpasswordValidation = (
  value,
  label = "Password",
  passwordValue
) => {
  console.log("check");
  let error = null;
  if (!value) {
    error = `Re-enter ${label} is required`;
  } else if (value !== passwordValue) {
    error = `${label} is not matching`;
  }
  return error;
};

const Password = ({ name, placeholder, label }) => {
  const initialValues = {
    password: "",
    reenterpassword: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };
  const handleSubmit = (e) => {
    e.preventDefault();

    setformErrors(passwordValidation(formValues));
    if (!Object.values(formValues).includes("")) {
      formValues.id = formValues.id === undefined ? Date.now() : formValues.id;
      setformValues({ ...formValues });
      setformValues(initialValues);
      console.log("user formvalues ", formValues);
      console.log(
        formValues.id === undefined ? "error" : Date.now() + formValues.id
      );
    }
  };
  return (
    <>
      <div className="form-group mb-3">
        <div>
          <label>{label}</label>
          <input
            type="password"
            className="form-control"
            name={name}
            placeholder={placeholder}
            // value={formValues.name}
            onChange={handleChanges}
            defaultValue={formValues.name}
          />
          <p className="text-danger">{formErrors.name}</p>
        </div>
      </div>
    </>
  );
};
export default Password;
