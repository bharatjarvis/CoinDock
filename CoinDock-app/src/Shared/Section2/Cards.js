import React from "react";
import { Card } from "react-bootstrap";
import "./Cards.css";

const Cards = ({ name, value, logo }) => {
  return (
    <Card className="card-individual">
      <Card className="coinperformance-inside-card">
        <img src={logo} alt="coin_logo" className="cd_coin_logo_name"></img>
      </Card>
      <p className="cd-coin-name">{name}</p>
      <p className="cd-coin-value">{value} </p>
    </Card>
  );
};
export default Cards;
