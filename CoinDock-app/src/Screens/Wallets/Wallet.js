import { useCoinCard } from "App/Api/coincardapi";
import React from "react";
import { Card, CardGroup } from "react-bootstrap";
import "./Wallet.css";

const Wallet = () => {
  const { data: coincard } = useCoinCard();

  return Object.values(coincard?.results ?? {}).map((value) => {
    return (
      <CardGroup className="mt-4 container ">
        <Card className="cd_coin_card_logo">
          <Card.Body>
            <Card.Title>
              <img src={value?.logo} className="cd_coin_logo" alt="coin_logo" />
            </Card.Title>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value?.BTC_coin}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              BTC
            </Card.Subtitle>
          </Card.Body>
        </Card>
        <Card className="cd_coin_card_logo">
          <Card.Body>
            <Card.Title>{value?.number_of_coins}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              Coins
            </Card.Subtitle>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value?.primary_currency}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              INR
            </Card.Subtitle>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value?.secondary_currency}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              USD
            </Card.Subtitle>
          </Card.Body>
        </Card>
      </CardGroup>
    );
  });
};
export default Wallet;
