import React from "react";

import "Shared/common-styles/space.css";
import "./Dashboard.css";
import { PieChart } from "Shared/Chart/Doughnut/Doughnut";
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
import Loading from "Shared/Loading/Loading";
function Dashboard() {
  const { data: total } = useTotalCurrency();
  const { data: primary } = usePrimaryCurrency();
  const { data: top } = useTopperformer();
  const { data: low } = useLowperformer();
  console.log(top?.data?.results?.image_path);
  console.log(primary?.data?.results?.img_url);
  return (
    <React.Fragment>
      <div className="container p-2">
        <div className="container cd-performance-wrap justify-content-space-between">
        <div className="col-md-12">
          <div className="row m-1">
              <div className="col-md-3">{total && (
              <Cards
                name={total?.data?.results?.heading}
                value={total?.data?.results?.balance}
                logo={total?.data?.results?.img_url}
              />
            )}</div>
              <div className="col-md-3">{primary && (
              <Cards
                name={primary?.data?.results?.heading}
                value={primary?.data?.results?.balance.toFixed(2)}
                logo={primary?.data?.results?.img_url}
              />
            )}</div>
              <div className="col-md-3">{top && (
              <Cards
                name={top?.data?.results?.heading}
                value={top?.data?.results?.coin_name}
                logo={top?.data?.results?.image_path}
              />
            )}</div>
              <div className="col-md-3">{low && (
              <Cards
                name={low?.data?.results?.heading}
                value={low?.data?.results?.coin_name}
                logo={low?.data?.results?.image_path}
              />
            )}</div>







            </div>
          </div>
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
