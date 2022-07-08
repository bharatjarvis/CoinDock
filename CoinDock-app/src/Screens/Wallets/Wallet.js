import { useCoinCard } from "App/Api/coincardapi";
import React from "react";
import { Card, CardGroup } from "react-bootstrap";

const Wallet = () => {
  const { data: coincard } = useCoinCard();
  console.log(coincard);
  const walletList = {};
  Object.entries(coincard?.result ?? {}).forEach(([key, value]) => {
    console.log({ key, value });
    Object.entries(value).forEach(([ValueKey, valueValue]) => {
      console.log({ ValueKey, valueValue });
      walletList[ValueKey] = {
        name: ValueKey,
        ...walletList?.[ValueKey],
        [key]: valueValue,
      };
    });
  });
  console.log(walletList);
  console.log(Object.values(walletList));
  return Object.values(walletList).map((value) => {
    return (
      <CardGroup className="p-4">
        <Card>
          <Card.Body>
            <Card.Title>{value.name}</Card.Title>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value["coin-BTC"]}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              BTC
            </Card.Subtitle>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value["number_of_coins"]}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              No of Coins in {value.name}
            </Card.Subtitle>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value["primary_currency"]}</Card.Title>
            <Card.Subtitle className="mb-2 text-muted text-center">
              INR
            </Card.Subtitle>
          </Card.Body>
        </Card>
        <Card>
          <Card.Body>
            <Card.Title>{value["secondary_currency"]}</Card.Title>
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
