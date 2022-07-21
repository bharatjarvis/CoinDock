import React from "react";
import { Card } from "react-bootstrap";
import "./Cards.css";

const Cards = ({ name, value, logo }) => {
  return (
    // <div className="cd-flex-content-container">
    //   <div className="cd-currency-performance">{name}</div>
    //   <div className="cd-currency-value cd-mt-5 cd-mb-6 cd-mr-4">{value}</div>
    //   {/* <img src={img} alt={name}></img> */}
    // </div>
    // <Card className="cd-performance-card">
    //   <div>
    //     <div className="card-deck">
    //       <div className="cd-flex-content-container">
    //         <Card className="coinperformance-inside-card">
    //           {" "}
    //           {/* {logo ? ( */}
    //           <img
    //             src={logo}
    //             alt="coin_logo"
    //             className="cd_coin_logo_name"
    //           ></img>
    //           {/* ) : null} */}
    //         </Card>
    //         <div className="cd-coin-card-body">
    //           <p className="card-title cd-currency-performance text-end">{name}</p>
    //           <p className="card-text cd-currency-value text-end">{value} </p>
    //         </div>
    //       </div>
    //     </div>
    //   </div>
    // </Card>
    // <div className="container">
    //   <div className="row">
    <Card className="card-individual">
      <Card className="coinperformance-inside-card">
        {/* {logo ? ( */}
        <img src={logo} alt="coin_logo" className="cd_coin_logo_name"></img>
        {/* ) : null} */}
      </Card>
      <p className="cd-coin-name">{name}</p>
      <p className="cd-coin-value">{value} </p>
    </Card>
    //   </div>
    // </div>
  );
};
export default Cards;
