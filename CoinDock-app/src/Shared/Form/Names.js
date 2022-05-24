import React, { useState } from "react";
import Name from "./Name";

import "bootstrap/dist/css/bootstrap.min.css";

function Names(props) {
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

    setformErrors(handleValidation(formValues));
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

  const handleValidation = (values) => {
    const errors = {};
    if (!values.firstname) {
      errors.firstname = "Firstname is required";
    }
    if (!values.lastname) {
      errors.lastname = "Lastname is required";
    }
    return errors;
  };
  return (
    <>
      <div className="form-group mb-3">
        <div>
          <Name
            name="firstname"
            placeholder="First Name"
            label="First Name"
            value={formValues.firstname}
            onChange={handleChanges}
          />
        </div>
        <p className="text-danger">{formErrors.firstname}</p>
        <Name
          name="lastname"
          placeholder="Last Name"
          label="Last Name"
          value={formValues.lastname}
          onChange={handleChanges}
        />
        <p className="text-danger">{formErrors.lastname}</p>
      </div>
    </>
  );
}
export default Names;
