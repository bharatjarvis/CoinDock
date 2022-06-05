import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../../../Shared/common-styles/common.css";
import "./RecoveryBoxes.css";

function RecoveryBoxs(props) {
  return (
    <>
      <div className="code-box">
        {props.input ? (
          <input
            className="cd-box-data"
            type="text"
            value={props.code}
            name={props.index}
          />
        ) : (
          <p className="cd-box-data">{props?.code}</p>
        )}
        <p className="cd-box-index">{props.index}</p>
      </div>
    </>
  );
}
export default RecoveryBoxs;
