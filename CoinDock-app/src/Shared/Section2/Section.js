import React from "react";
import "./Section.css";
const Section = ({ name, value }) => {
  return (
    // <div className="cd-flex-container">
    <div className="cd-flex-content-container">
      <p className="cd-currency-performance">{name}</p>
      <p className="cd-currency-value cd-mt-5 cd-mb-6 cd-ml-39 cd-mr-4">
        {value}
      </p>
      {/* </div> */}
    </div>
  );
};
export default Section;
