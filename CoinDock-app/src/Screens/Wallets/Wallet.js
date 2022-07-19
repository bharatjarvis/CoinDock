import { useCoinCard } from "App/Api/coincardapi";
import React from "react";
import { Card, CardGroup } from "react-bootstrap";
import "./Wallet.css";

const Wallet = () => {
  const { data: coincard } = useCoinCard();

  return (
    <div class="cd-wallet-card cd-pagetitle mt-5000 container">
      <div class="card p-3">
        <h6>Wallets</h6>
        {Object.values(coincard?.data?.results ?? {}).map((value) => {
          return (
            // <CardGroup className="mt-4 container ">
            //   <Card className="cd_coin_card_logo">
            //     <Card.Body>
            //       <Card.Title>
            //         <img src={value?.logo} className="cd_coin_logo" alt="coin_logo" />
            //       </Card.Title>
            //     </Card.Body>
            //   </Card>
            //   <Card>
            //     <Card.Body>
            //       <Card.Title>{value?.BTC_coin}</Card.Title>
            //       <Card.Subtitle className="mb-2 text-muted text-center">
            //         BTC
            //       </Card.Subtitle>
            //     </Card.Body>
            //   </Card>
            //   <Card className="cd_coin_card_logo">
            //     <Card.Body>
            //       <Card.Title>{value?.number_of_coins}</Card.Title>
            //       <Card.Subtitle className="mb-2 text-muted text-center">
            //         Coins
            //       </Card.Subtitle>
            //     </Card.Body>
            //   </Card>
            //   <Card>
            //     <Card.Body>
            //       <Card.Title>{value?.primary_currency}</Card.Title>
            //       <Card.Subtitle className="mb-2 text-muted text-center">
            //         INR
            //       </Card.Subtitle>
            //     </Card.Body>
            //   </Card>
            //   <Card>
            //     <Card.Body>
            //       <Card.Title>{value?.secondary_currency}</Card.Title>
            //       <Card.Subtitle className="mb-2 text-muted text-center">
            //         USD
            //       </Card.Subtitle>
            //     </Card.Body>
            //   </Card>
            // </CardGroup>

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
                      <h6 className="text-end">{value?.primary_currency}</h6>
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
