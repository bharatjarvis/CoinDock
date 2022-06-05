import React, { useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./CheckBox.css";

function Checkbox(props) {
  const [checked, setChecked] = useState(props.checked);
  const handleOnChange = (event) => {
    if (props.onChange) {
      props.onChange(event);
    }
    setChecked((checked) => !checked);
  };

  return (
    <div className="cd-checkbox-container">
      <input
        type="checkbox"
        id="Checkbox"
        className="cd-check-box"
        checked={checked}
        onChange={handleOnChange}
      />

      <label htmlFor="Checkbox" className="cd-label">
        {" "}
        {props.label}
      </label>
    </div>
  );
}
export default Checkbox;
