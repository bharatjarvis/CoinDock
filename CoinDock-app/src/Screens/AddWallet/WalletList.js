import React from "react";

const WalletList = ({ walletlist }) => {
  return (
    <div>
      {walletlist.map((wallet, index) => (
        <div key={index}>
          <h5>{wallet}</h5>
        </div>
      ))}
    </div>
  );
};

export default WalletList;
