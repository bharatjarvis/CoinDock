import React from "react";
import "./Popup.css";

function Popup(props) {
  const handleClick =() =>{
    props.buttonOnclick?.()
    props.setTrigger(false)
  }

  return props.trigger ? (
    <div className="cd-popup">
      <div className="cd-popup-inner">
        {props.children}
        <div className="d-flex justify-content-center cd-mt-39">
          <button
            className="cd-button cd-button-2 "
            onClick={handleClick}
          >
            {props.buttonLable}
          </button>
        </div>
      </div>
    </div>
  ) : (
    <React.Fragment/>
  );
}

export default Popup;
