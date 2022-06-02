import React from "react";
import "./Section.css";
const Section = ({ name, value }) => {
  return (
    <div className="cd-flex-container">
      <div>
        <p>
          <p className="cd-currency-performance">{name}</p>
          <p className="cd-currency-value">{value}</p>
        </p>
      </div>
    </div>
  );
};
export default Section;
