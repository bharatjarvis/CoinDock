import { useCoinCard } from "App/Api/coincardapi";
import React from "react";

import EllipseNumber from "Shared/EllipeseText";

import "./Wallet.css";

const Wallet = () => {
  const { data: coincard, isLoading, isError } = useCoinCard();

  if (isLoading || isError) {
    return null;
  }

  return (
    <div class="cd-wallet-card cd-pagetitle mt-5000 container">
      <div class="card p-3">
        <h6>Wallets</h6>
        {Object.values(coincard?.data?.results ?? {}).map((value) => {
          return (
            <div className="card-block">
              <div className="col-md-12 card p-3">
                <div className="row">
                  <div className="col-md-2">
                    <div className="photo-box">
                      <h6>
                        <img
                          src={value?.logo}
                          className="cd_coin_logo"
                          alt={value.coin_name}
                        />
                      </h6>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div className="photo-box">
                      <EllipseNumber
                        component="h6"
                        text={value?.BTC_coin?.toString() ?? ""}
                        className="text-end"
                        maxLetters={4}
                      />

                      <p className="mb-2 text-muted text-end">BTC</p>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div class="photo-box">
                      <h6 className="text-end">{value?.number_of_coins}</h6>
                      <p className="mb-2 text-muted text-end">Coins</p>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div className="photo-box">
                      <h6 className="text-end">
                        {value?.primary_currency.toFixed(2)}
                      </h6>
                      <p className="mb-2 text-muted text-end">
                        {value?.primary_currency_code}
                      </p>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div className="photo-box">
                      <h6 className="text-end">{value?.secondary_currency}</h6>
                      <p className="mb-2 text-muted text-end">
                        {value?.secondary_currency_code}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
};
export default Wallet;
