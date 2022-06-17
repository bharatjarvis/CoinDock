import React from "react";

import "Shared/common-styles/space.css";
import "./Dashboard.css";
import { PieChart } from "Shared/Chart/PieChart/PieChart";
import { LineChart } from "Shared/Chart/LineChart/LineChart";
import "Shared/common-styles/space.css";
import Cards from "Shared/Section2/Cards";

function Dashboard() {
  return (
    <React.Fragment>
      <div className="container">
        <div className="cd-performance-wrap">
          <Cards name="Total BTC" value=" ₿0.00001" />
          <Cards name="Primary Currency" value="$26.72" />
          <Cards name="Top Performer" value="BTC" />
          <Cards name="Low Performer" value="ETH" />
        </div>
        <div className="row">
          <div className="col">
            {" "}
            <LineChart />
          </div>
          <div className="col cd-pie-margin">
            <PieChart />
          </div>
        </div>
      </div>
    </React.Fragment>
  );
}

export default Dashboard;
