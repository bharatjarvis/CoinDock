import React from "react";

import "Shared/common-styles/space.css";
import "./Dashboard.css";
import { PieChart } from "Shared/Chart/PieChart/PieChart";
import { LineChart } from "Shared/Chart/LineChart/LineChart";
import "Shared/common-styles/space.css";
import Cards from "Shared/Section2/Cards";
import Wallet from "Screens/Wallets/Wallet";
import { useTopperformer } from "App/Api/CoinPerformence/coinperformance";
import { useLowperformer } from "App/Api/CoinPerformence/coinperformance";
import { usePrimaryCurrency } from "App/Api/CoinPerformence/coinperformance";
import { useTotalCurrency } from "App/Api/CoinPerformence/coinperformance";
function Dashboard() {
  const { data: total } = useTotalCurrency();
  const { data: primary } = usePrimaryCurrency();
  const { data: top } = useTopperformer();
  const { data: low } = useLowperformer();
  console.log(top);

  return (
    <React.Fragment>
      <div className="cd-performance-wrap justify-content-space-between p-14">
        {total && (
          <Cards
            name={total?.result?.heading}
            value={total?.result?.balance}
            //  img={total?.result?.img_url}
          />
        )}

        {primary && (
          <Cards
            name={primary?.result?.heading}
            value={primary?.result?.balance}
          />
        )}
        {top && (
          <Cards name={top?.result?.heading} value={top?.result?.coin_name} />
        )}
        {low && (
          <Cards name={low?.result?.heading} value={low?.result?.coin_name} />
        )}
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
