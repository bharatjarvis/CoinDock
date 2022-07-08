import React from "react";
import "./Cards.css";

const Cards = ({ name, value, img }) => {
  return (
    <div className="cd-flex-content-container">
      <div className="cd-currency-performance">{name}</div>
      <div className="cd-currency-value cd-mt-5 cd-mb-6 cd-mr-4">{value}</div>
      {/* <img src={img} alt={name}></img> */}
    </div>
  );
};
export default Cards;
