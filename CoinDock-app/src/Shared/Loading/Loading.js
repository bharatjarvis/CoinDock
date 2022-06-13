import React from "react";
import Spinner from "react-bootstrap/esm/Spinner";
import styles from "./Loading.css";

function Loading() {
  return (
    <div
      className={`container-fluid d-flex justify-content-center align-items-center ${styles.spinner_bg} `}
    >
      <Spinner animation="border" variant="primary" />
    </div>
  );
}

export default Loading;
