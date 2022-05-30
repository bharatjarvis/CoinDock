import React, { useState } from "react";
export const nameValidation = (value, label = "Name") => {
  let error = null;

  if (!value) {
    error = `${label} is required`;
  }
  return error;
};

const Name = ({ label, name, placeholder }) => {
  const initialValues = {
    firstname: "",
    lastname: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };
  const handleSubmit = (e) => {
    e.preventDefault();

    setformErrors(nameValidation(formValues));
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
    <div className="form-group mb-3">
      <div>
        <label>{label}</label>
        <input
          type="text"
          className="form-control"
          name={name}
          placeholder={placeholder}
          value={formValues.name}
          onChange={handleChanges}
        />
      </div>
      <p className="text-danger">{formErrors.name}</p>
    </div>
  );
};
export default Name;
