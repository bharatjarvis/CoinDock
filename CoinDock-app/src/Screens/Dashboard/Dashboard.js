import React from "react";

import "Shared/common-styles/space.css";
import "./Dashboard.css";
import { PieChart } from "Shared/Chart/PieChart/PieChart";
import { LineChart } from "Shared/Chart/LineChart/LineChart";
import "Shared/common-styles/space.css";
import Cards from "Shared/Section2/Cards";
import Wallet from "Screens/Wallets/Wallet";
import { useTotalbtc } from "App/Api/CoinPerformence/totalbtcapi";
import { usePrimary } from "App/Api/CoinPerformence/primarycurrencyapi";
import { useTopperformer } from "App/Api/CoinPerformence/topperformerapi";
import { useLowperformer } from "App/Api/CoinPerformence/lowperformerapi";
function Dashboard() {
  const { data: totalbtc } = useTotalbtc();
  const { data: primary } = usePrimary();
  const { data: top } = useTopperformer();
  const { data: low } = useLowperformer();
  return (
    <React.Fragment>
      <div
        className="cd-performance-wrap justify-content-space-between p-14"

      >
        {/* <div className="row">
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
        </div> */}
        {totalbtc &&
          totalbtc.map((totalbtc, id) => {
            return (
              <Cards key={id} name={totalbtc.name} value={totalbtc.value} />
            );
          })}
        {primary &&
          primary.map((primary, id) => {
            return <Cards key={id} name={primary.name} value={primary.value} />;
          })}
        {top &&
          top.map((top, id) => {
            return <Cards key={id} name={top.name} value={top.value} />;
          })}
        {low &&
          low.map((low, id) => {
            return <Cards key={id} name={low.name} value={low.value} />;
          })}
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
