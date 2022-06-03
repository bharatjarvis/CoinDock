import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../../../Shared/common-styles/common.css";
import "./RecoveryBoxes.css";

function RecoveryBoxs(props) {
  return (
    <>
      <div
        style={{
          marginLeft: "40%",
          marginTop: "60px",
          width: "200px",
          display: "flex",
          flexWrap: "initial",
        }}
      ></div>
      <div className="code-box">
        <p className="cd-box-data">{props.code}</p>
        <p className="cd-box-index">{props.value + 1}</p>
      </div>
    </>
  );
}
export default RecoveryBoxs;
