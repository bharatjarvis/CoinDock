import { React, useState, useEffect } from "react";
import "./Select.css";
import "../../common-styles/space.css";

export const countryValidation = (value) => {
  let error = null;
  if (!value) {
    error = "Country is required";
  }
  return error;
};

const Select = ({
  options,
  label,
  emptyPlaceHolder,
  name,
  formErrors,

  ...props
}) => {
  const initialValues = {
    country: "",
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
      <label className="cd-mt-12">{label}</label>
      <select
        className="form-control cd-select cd-mt-8"
        name={name}
        onBlur={handleFocus}
      >
        {emptyPlaceHolder && <option />}
        {options.map(({ value, label }, index) => {
          return (
            <option value={value} key={index} onClick={handleChanges}>
              {label}
            </option>
          );
        })}
      </select>
      {fieldsTouched && <p className="text-danger">{formErrors[name]}</p>}
    </>
  );
};

export default Select;
