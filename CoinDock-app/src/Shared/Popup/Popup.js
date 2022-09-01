import React from "react";
import "./Popup.css";
import PropTypes from "prop-types";
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
  trigger: PropTypes.bool,
  buttonLable: PropTypes.string,
  disabled: PropTypes.bool,
  children: PropTypes.element,
};

export default Popup;
