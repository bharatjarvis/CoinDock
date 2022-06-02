import React, { useState, useEffect } from "react";
import propTypes from "prop-types";
import "../../../Shared/common-styles/space.css";
export const nameValidation = (value, label = "Name", length = 0) => {
  let error = null;

  if (!value) {
    error = `${label} is required`;
  } else if (value.length > 45) {
    error = ` The ${label} may not be greater than ${length} characters.`;
  }
  return error;
};

const Name = ({ label, name, placeholder, formErrors }) => {
  const initialValues = {
    firstname: "",
    lastname: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [fieldsTouched, setFieldsTouched] = useState(false);

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };
  const handleFocus = (e) => {
    console.log(e);
    setFieldsTouched(true);
  };

  return (
    <div className="form-group">
      <div>
        <label className="cd-mt-12">{label}</label>
        <input
          type="text"
          className="form-control cd-mt-8"
          name={name}
          placeholder={placeholder}
          value={formValues.name}
          onChange={handleChanges}
          defaultValue={formValues.name}
          onBlur={handleFocus}
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
};
export default Name;
