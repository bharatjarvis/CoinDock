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
import { Card } from "react-bootstrap";
import { isEmpty, isError } from "lodash";
function Dashboard() {
  const { data: total } = useTotalCurrency();
  const { data: primary } = usePrimaryCurrency();
  const { data: top } = useTopperformer();
  const { data: low } = useLowperformer();
  console.log({ total, primary, top, low });

  // if (isError || isEmpty(total?.data?.results)) {
  //   return null;
  // }
  // if (isError || isEmpty(primary?.data?.results)) {
  //   return null;
  // }
  // if (isError || isEmpty(top?.data?.results)) {
  //   return null;
  // }
  // if (isError || isEmpty(low?.data?.results)) {
  //   return null;
  // }
  console.log(primary);
  console.log(top);
  return (
    <React.Fragment>
      <div className="container p-20">
        <div className="cd-performance-wrap justify-content-space-between">
          {total && (
            <Cards
              name={total?.data?.results?.heading}
              value={total?.data?.results?.balance}
              logo={total?.data?.results?.img_url}
            />
          )}

          {primary && (
            <Cards
              name={primary?.data?.results?.heading}
              value={primary?.data?.results?.balance}
              logo={primary?.data?.results?.img_url}
            />
          )}

          {top && (
            <Cards
              name={top?.data?.results?.heading}
              value={top?.data?.results?.coin_name}
              logo={top?.data?.results?.img_path}
            />
          )}

          {low && (
            <Cards
              name={low?.data?.results?.heading}
              value={low?.data?.results?.coin_name}
              logo={low?.data?.results?.img_path}
            />
          )}
        </div>
        <div className="container justify-content-center">
          <div class="row">
            <div class="col-md-7">
              <LineChart />
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
              <PieChart />
            </div>
          </div>
        </div>
        <Wallet />
      </div>
    </React.Fragment>
  );
}

export default Dashboard;
