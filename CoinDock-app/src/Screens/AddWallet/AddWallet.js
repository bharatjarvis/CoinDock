import { React, useState } from "react";
import Select from "Shared/Form/Select";
import Name from "Shared/Form/Name/Name";
import { RiCloseLine } from "react-icons/ri";
import Popup from "Screens/Popup/Popup";

const AddWallet = () => {
  const [buttonPopup, setButtonPopup] = useState(false);
  return (
    <>
      <form>
        <Popup
          trigger={buttonPopup}
          setTrigger={setButtonPopup}
          buttonLable="Done"
        >
          <div className="d-flex justify-content-between">
            <h4>Wallet</h4>
            <RiCloseLine
              size="30px"
              cursor="pointer"
              onClick={() => setButtonPopup(false)}
            />
          </div>

          <Select
            name="Wallet"
            className="form-control"
            label="Wallet"
            options={[
              { label: "" },
              { label: "BitCoin", value: 1 },
              { label: "Ethereum", value: 2 },
            ]}
          />

          <Name
            name="Wallet Address"
            placeholder="Wallet Address "
            label="Wallet Address"
          />
          <Name
            name="Wallet Name"
            placeholder="Wallet Name"
            label="Wallet Name"
          />
        </Popup>
      </form>
    </>
  );
};

export default AddWallet;
