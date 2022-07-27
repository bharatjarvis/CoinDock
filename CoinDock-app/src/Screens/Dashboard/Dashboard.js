import React, { useEffect, useState } from "react";

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
import DownArrow from "Shared/images/downarrow.jpg";
import UpArrow from "Shared/images/uparrow.png";

function Dashboard() {
  const [isLoaded, setIsLoaded] = useState(false);
  const { data: total } = useTotalCurrency();
  const { data: primary } = usePrimaryCurrency();
  const { data: top } = useTopperformer();
  const { data: low } = useLowperformer();
  useEffect(() => {
    setTimeout(() => {
      setIsLoaded(true);
    }, 3000);
  }, []);

  return (
    <React.Fragment>
      {isLoaded && (
        <div className="container p-2">
          <div className="container cd-performance-wrap justify-content-space-between">
            <div className="col-md-12">
              <div className="row m-1">
                <div className="col-md-3">
                  {total && (
                    <Cards
                      name={total?.data?.results?.heading}
                      value={total?.data?.results?.balance}
                      logo={total?.data?.results?.img_url}
                    />
                  )}
                </div>
                <div className="col-md-3">
                  {primary && (
                    <Cards
                      name={primary?.data?.results?.heading}
                      value={primary?.data?.results?.balance.toFixed(2)}
                      logo={primary?.data?.results?.img_url}
                    />
                  )}
                </div>
                <div className="col-md-3">
                  {top && (
                    <Cards
                      name={top?.data?.results?.heading}
                      value={top?.data?.results?.coin_name.replace()}
                      logo={UpArrow}
                    />
                  )}
                </div>
                <div className="col-md-3">
                  {low && (
                    <Cards
                      name={low?.data?.results?.heading}
                      value={low?.data?.results?.coin_name}
                      logo={DownArrow}
                    />
                  )}
                </div>
              </div>
              <div className="container justify-content-center">
                <div className="row">
                  <div className="col-md-7">
                    <LineChart />
                  </div>
                  <div className="col-md-1"></div>
                  <div className="col-md-4">
                    <PieChart />
                  </div>
                </div>
              </div>
              <Wallet />
            </div>
          </div>
        </div>
      )}
    </React.Fragment>
  );
}

export default Dashboard;
