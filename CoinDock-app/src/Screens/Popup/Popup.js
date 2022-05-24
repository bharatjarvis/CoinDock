import React from "react";
import "./Popup.css";

function Popup(props) {
  return props.trigger ? (
    <div className="popup">
      <div className="start"></div>
      <div className="popup-inner">
        {props.children}
        <button className="cd-button cd-button-2" onClick={() => props.setTrigger(false)}>
          Ok
        </button>
      </div>
    </div>
  ) : (
    ""
  );
}

export default Popup;
