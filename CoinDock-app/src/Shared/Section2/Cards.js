import React from "react";
import "./Cards.css";

const Cards = ({ name, value, logo }) => {
  return (
    // <div className="cd-flex-content-container">
    //   <div className="cd-currency-performance">{name}</div>
    //   <div className="cd-currency-value cd-mt-5 cd-mb-6 cd-mr-4">{value}</div>
    //   {/* <img src={img} alt={name}></img> */}
    // </div>

    <div>
      <div className="card-deck">
        <div className="card cd-flex-content-container">
          <div className="card-body">
            <p className="card-title cd-currency-performance">{name}</p>
            <p className="card-text cd-currency-value">
              {value}{" "}
              {logo ? (
                <img
                  src={logo}
                  alt="coin_logo"
                  className="cd_coin_logo_name"
                ></img>
              ) : null}
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};
export default Cards;
