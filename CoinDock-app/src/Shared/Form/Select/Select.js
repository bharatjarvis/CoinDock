import React from "react";

const Select = ({ options, label, emptyPlaceHolder, name, ...props }) => {
  return (
    <>
      <label>{label}</label>
      <select className="form-control mt-1 py-8" name={name}>
        {emptyPlaceHolder && <option />}
        {options.map(({ value, label }, index) => {
          return (
            <option value={value} key={index}>
              {label}
            </option>
          );
        })}
      </select>
    </>
  );
};

export default Select;
