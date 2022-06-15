import React from "react";
import { RiCloseLine } from "react-icons/ri";
import Select from "Shared/Form/Select";
import Name from "Shared/Form/Name/Name";
import Popup from "Shared/Popup/Popup";
import { useSelector, useDispatch } from "react-redux";
import { closePopup } from "Screens/AddWallet/AddWalletSlice";

function AddWallet() {
  const open = useSelector((state) => state.addwallet.open);
  const dispatch = useDispatch();

  const handleSetTrigger = () => {
    dispatch(closePopup());
  };

  return (
    <div>
      <form>
        <Popup trigger={open} setTrigger={handleSetTrigger} buttonLable="Done">
          <div className="d-flex justify-content-between">
            <h4>Wallet</h4>
            <RiCloseLine
              size="30px"
              cursor="pointer"
              onClick={() => handleSetTrigger(false)}
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
    </div>
  );
}

export default AddWallet;
