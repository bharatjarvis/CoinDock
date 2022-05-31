import React, { useEffect, useState } from "react";
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

const Email = ({ name, formErrors }) => {
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
    console.log(e);
    setFieldsTouched(true);
  };

  useEffect(() => {
    console.log(fieldsTouched);
  }, [fieldsTouched]);

  return (
    <>
      <div className="form-group mb-3">
        <div>
          <label>Email</label>
          <input
            type="email"
            className="form-control"
            name={name}
            placeholder="Enter your Email address"
            onChange={handleChanges}
            defaultValue={formValues.email}
            onBlur={handleFocus}
          />
          {fieldsTouched && <p className="text-danger">{formErrors[name]}</p>}
        </div>
      </div>
    </>
  );
};
export default Email;
