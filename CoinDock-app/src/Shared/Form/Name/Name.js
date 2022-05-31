import React, { useState, useEffect } from "react";
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

  useEffect(() => {
    console.log(fieldsTouched);
  }, [fieldsTouched]);

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
          defaultValue={formValues.name}
          onBlur={handleFocus}
        />
      </div>
      {fieldsTouched && <p className="text-danger">{formErrors[name]}</p>}
    </div>
  );
};
export default Name;
