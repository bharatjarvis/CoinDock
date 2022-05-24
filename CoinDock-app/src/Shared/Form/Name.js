import React from "react";

const Name = ({ label, name, placeholder }) => {
  return (
    <div className="form-group mb-3">
      <div>
        <label>{label}</label>
        <input
          type="text"
          className="form-control"
          name={name}
          placeholder={placeholder}
        />
      </div>
    </div>
  );
};
export default Name;
