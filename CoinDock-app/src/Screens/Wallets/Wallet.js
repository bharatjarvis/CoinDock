import React from "react";
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
    <div className="container p-2">
      <div className="card mt-5 mb-4">
        <div className="card-body">
          <div className="row">
            <div className="col-md-3">Logo</div>

            <div className="col-md-3">Coin BTC</div>
            <div className="col-md-2">No.of Coins</div>
            <div className="col-md-2">Primary Currency</div>
            <div className="col-md-2">Secondary Currency</div>
          </div>
        </div>
      </div>
    </div>
  );
};
export default Wallet;
