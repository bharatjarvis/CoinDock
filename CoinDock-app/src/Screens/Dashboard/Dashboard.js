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

  return (
    <React.Fragment>
      <div className="cd-performance-wrap justify-content-space-between p-14">
        {total && (
          <Cards
            name={total?.result?.["total-BTC"]?.name}
            value={total?.result?.["total-BTC"]?.total}
          />
        )}

        {primary && (
          <Cards
            name={primary?.result?.["total-INR"]?.name}
            value={primary?.result?.["total-INR"]?.primaryCurrency}
          />
        )}
        {top && (
          <Cards
            name={top?.result?.["Top-Performer"]?.name}
            value={top?.result?.["Top-Performer"]?.balance}
          />
        )}
        {low && (
          <Cards
            name={low?.result?.["Low-Performer"]?.name}
            value={low?.result?.["Low-Performer"]?.balance}
          />
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
