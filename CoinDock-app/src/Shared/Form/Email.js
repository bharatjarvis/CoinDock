import React, { useState } from "react";

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

function Email(props) {
  const [buttonPopup, setButtonPopup] = useState(false);
  const initialValues = {
    email: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    setformErrors(emailValidation(formValues));
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
        <label>Email</label>
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
