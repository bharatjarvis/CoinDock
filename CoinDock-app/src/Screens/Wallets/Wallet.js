import { useCoinCard } from "App/Api/coincardapi";
import React from "react";
import LinesEllipsis from "react-lines-ellipsis";

import { PlusCircle } from "react-bootstrap-icons";
import { openPopup } from "Screens/AddWallet/AddWalletSlice";
import { useDispatch } from "react-redux";
import "./Wallet.css";

const Wallet = () => {
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
                      <h6 className="text-end">{value?.BTC_coin}</h6>
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
                      <p className="mb-2 text-muted text-end">INR</p>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div className="photo-box">
                      <h6 className="text-end">{value?.secondary_currency}</h6>
                      <p className="mb-2 text-muted text-end">USD</p>
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
