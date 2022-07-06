import React from "react";
import { Card, CardGroup } from "react-bootstrap";
// import Section from "Shared/Section2/Cards";
import "./Wallet.css";

const Wallet = () => {
  return (
    // <div className="container ">
    //   <div className="card cd-direction">
    //     <Section name="Logo" value="" />
    //     <Section name="Coin BTC" value="" />
    //     <Section name="No.of Coins" value="" />
    //     <Section name="Primary Currency" value="" />
    //     <Section name="Secondary Currency" value="" />
    //   </div>
    // </div>
    // <div className="container p-2">
    //   <div className="card mt-5 mb-4">
    //     <div className="card-body">
    //       <div className="row">
    //         <div className="col-md-3">Logo</div>

    //         <div className="col-md-3">Coin BTC</div>
    //         <div className="col-md-2">No.of Coins</div>
    //         <div className="col-md-2">Primary Currency</div>
    //         <div className="col-md-2">Secondary Currency</div>
    //       </div>
    //     </div>
    //   </div>
    // </div>
    <CardGroup className="p-4">
      <Card>
        <Card.Body>
          <Card.Title>Logo</Card.Title>
        </Card.Body>
      </Card>
      <Card>
        <Card.Body>
          <Card.Title>Coin BTC</Card.Title>
          <Card.Subtitle className="mb-2 text-muted text-center">
            BTC
          </Card.Subtitle>
        </Card.Body>
      </Card>
      <Card>
        <Card.Body>
          <Card.Title>No of Coins</Card.Title>
        </Card.Body>
      </Card>
      <Card>
        <Card.Body>
          <Card.Title>Primary Currency</Card.Title>
          <Card.Subtitle className="mb-2 text-muted text-center">
            INR
          </Card.Subtitle>
        </Card.Body>
      </Card>
      <Card>
        <Card.Body>
          <Card.Title>Secondary Currency</Card.Title>
          <Card.Subtitle className="mb-2 text-muted text-center">
            USD
          </Card.Subtitle>
        </Card.Body>
      </Card>
    </CardGroup>
  );
};
export default Wallet;
