import React from "react";
import Section from "Shared/Section2/Section";
import "Shared/common-styles/space.css";
import "./Dashboard.css";
import { PieChart } from "Shared/Chart/PieChart/PieChart";
import { LineChart } from "Shared/Chart/LineChart/LineChart";
import "Shared/common-styles/space.css";
function Dashboard() {
  return (
    <React.Fragment>
      <div className="container">
        <div className="cd-performance-wrap">
          <Section name="Total BTC" value=" ₿0.00001" />
          <Section name="Total Primary Currency" value="$26.72" />
          <Section name="Top Performer" value="BTC" />
          <Section name="Low Performer" value="Ethereum" />
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
