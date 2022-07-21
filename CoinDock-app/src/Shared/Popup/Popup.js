import React from "react";
import { propTypes } from "react-bootstrap/esm/Image";
import "./Popup.css";

function Popup(props) {
  const handleClick = () => {
    props.buttonOnclick?.();
    props.setTrigger(false);
  };

  return props.trigger ? (
    <div className="cd-popup">
      <div className="cd-popup-inner">
        {props.children}
        <div className="d-flex justify-content-center cd-mt-39">
          <button
            className="cd-button cd-button-2 "
            onClick={handleClick}
            disabled={props.disabled}
          >
            {props.buttonLable}
          </button>
        </div>
      </div>
    </div>
  ) : (
    <React.Fragment />
  );
}
Popup.propTypes = {
  trigger: propTypes.function,
  buttonLable: propTypes.string,
  disabled: propTypes.boolean,
  children: propTypes.element,
};

export default Popup;
