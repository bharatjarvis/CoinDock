import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../../../Shared/common-styles/common.css";
import "./RecoveryBoxes.css";

function RecoveryBoxs(props) {
  return (
    <>
      <div className="code-box">
        <p className="cd-box-data">{props?.code}</p>
        <p className="cd-box-index">{props.value + 1}</p>
      </div>
    </>
  );
}
export default RecoveryBoxs;
