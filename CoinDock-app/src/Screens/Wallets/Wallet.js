import { useCoinCard } from "App/Api/coincardapi";
import React from "react";

import EllipseNumber from "Shared/EllipeseText";

import { PlusCircle } from "react-bootstrap-icons";
import { openPopup } from "Screens/AddWallet/AddWalletSlice";
import { useDispatch } from "react-redux";
import "./Wallet.css";

function Wallet() {
  const { data: coincard, isLoading, isError } = useCoinCard();
  const dispatch = useDispatch();

  if (isLoading || isError) {
    return null;
  }

  return (
    <div className="cd-wallet-card cd-pagetitle mt-5000 container">
      <div className="card p-3">
        <div
          className="cd-row-space-between"
          style={{ display: "flex", width: "100%" }}
        >
          <h6>Wallets</h6>
          <PlusCircle size={30} onClick={() => dispatch(openPopup())} />
        </div>

        {Object.values(coincard?.data?.results ?? {}).map((value, index) => {
          return (
            <div className="card-block" key={index}>
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
                        classNames="text-end"
                        maxLetters={4}
                      />

                      <p className="mb-2 text-muted text-end">BTC</p>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div className="photo-box">
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
}
export default Wallet;
