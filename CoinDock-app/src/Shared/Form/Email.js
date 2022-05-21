import React, { useState } from "react";
function Email() {
  const initialValues = { email: "" };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };
  const handleSubmit = (e) => {
    e.preventDefault();
    setformErrors(handleValidation(formValues));
  };
  const handleValidation = (values) => {
    const errors = {};
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
    if (!values.email) {
      errors.email = "Email is required!";
    } else if (!regex.test(values.email)) {
      errors.email = "This is not a valid email format!";
    }
    return errors;
  };
  return (
    <>
      <div className="form-group mb-3">
        <input
          type="email"
          name="email"
          className="form-control mt-1 py-8"
          placeholder="Enter your email address"
          value={formValues.email}
          id="email"
          onChange={handleChanges}
        />
      </div>
      <p className="text-danger">{formErrors.email}</p>
    </>
  );
}
export default Email;
