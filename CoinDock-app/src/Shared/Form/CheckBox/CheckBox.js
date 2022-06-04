import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./CheckBox.css";

function Checkbox(props) {
  return (
    <div className="cd-checkbox-container">
      <input type="checkbox" id="Checkbox" className="check-box" required />

      <label htmlFor="Checkbox" className="label">
        {" "}
        {props.label}
      </label>
    </div>
  );
}
export default Checkbox;
