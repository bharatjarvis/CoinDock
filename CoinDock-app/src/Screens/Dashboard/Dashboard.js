import React from "react";

import "Shared/common-styles/space.css";
import "./Dashboard.css";
import { PieChart } from "Shared/Chart/PieChart/PieChart";
import { LineChart } from "Shared/Chart/LineChart/LineChart";
import "Shared/common-styles/space.css";
import Cards from "Shared/Section2/Cards";
import Wallet from "Screens/Wallets/Wallet";

function Dashboard() {
  return (
    <React.Fragment>
      <div className="cd-performance-wrap justify-content-center  align-items-center">
        <div className="row">
          <div className="col">
            <Cards name="Total BTC" value=" ₿0.00001" />
          </div>
          <div className="col">
            <Cards name="Primary Currency" value="$26.72" />
          </div>

          <div className="col">
            <Cards name="Top Performer" value="BTC" />
          </div>
          <div className="col">
            <Cards name="Low Performer" value="ETH" />
          </div>
        </div>
      </div>
      <div className="container justify-content-center">
        <div className="row">
          <div className="col">
            <LineChart />
          </div>
          <div className="col cd-pie-margin">
            <PieChart />
          </div>
        </div>
      </div>
      <Wallet />
    </React.Fragment>
  );
}

export default Dashboard;
