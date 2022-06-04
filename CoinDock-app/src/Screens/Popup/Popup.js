import React from "react";
import "./Popup.css";
import { useNavigate } from "react-router-dom";
import "../../Shared/common-styles/common.css";

function Popup(props) {
  const navigate = useNavigate();

  const handleOnClick = () => {
    props.setTrigger(false);
    navigate("/recovery-codes");
  };

  return props.trigger ? (
    <div className="popup">
      <div className="popup-inner">
        {props.children}
        <div className="cd-content-row-end">
          <button className="cd-button cd-button-2" onClick={handleOnClick}>
            {props.buttonLable}
          </button>
        </div>
      </div>
    </div>
  ) : (
    ""
  );
}

export default Popup;
