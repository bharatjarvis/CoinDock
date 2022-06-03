import React from "react";
import "./Popup.css";

function Popup(props) {
  return props.trigger ? (
    <div className="popup">
      <div className="popup-inner">
        {props.children}
        <button
          className="cd-button cd-button-2"
          onClick={() => props.setTrigger(false)}
        >
          {props.buttonLable}
        </button>
      </div>
    </div>
  ) : (
    ""
  );
}

export default Popup;
