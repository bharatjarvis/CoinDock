import { React, useState } from "react";
import "./Select.css";
import propTypes from "prop-types";
import "Shared/common-styles/space.css";
import "Shared/common-styles/common.css";

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
  value,
  name,
  formErrors,
  onInput,

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
    setFieldsTouched(true);
  };
  const handleInput = (e) => {
    setFieldsTouched(true);
    onInput?.(e);
  };
  
  return (
    <>
      <label className="cd-mt-12 cd-lable-signup">{label}</label>
      <select
        className="form-control cd-select cd-mt-8"
        name={name}
        defaultValue={value}
        onBlur={handleFocus}
      >
        {emptyPlaceHolder && <option />}
        {options.map(({value,label}, index) => {
          return (
            <option
              value={value}
              key={index}
              onClick={handleChanges}
              onInput={handleInput}
            >
              {label}
            </option>
          );
        })}
      </select>
      {fieldsTouched && formErrors && (
        <p className="text-danger">{formErrors[name]}</p>
      )}
    </>
  );
};
Select.defaultProps ={
  formErrors : {}
};
Select.propTypes = {
  label: propTypes.string,
};
export default Select;