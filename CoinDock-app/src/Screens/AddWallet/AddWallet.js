import React, { useState } from "react";
import { RiCloseLine } from "react-icons/ri";
import Select from "Shared/Form/Select";

import Popup from "Shared/Popup/Popup";

import { useSelector, useDispatch } from "react-redux";
import { closePopup } from "Screens/AddWallet/AddWalletSlice";
import { walletnameValidation } from "Shared/Form/WalletFields/WalletName";
import WalletName from "Shared/Form/WalletFields/WalletName";
import { countryValidation } from "Shared/Form/Select/Select";

function AddWallet() {
  const open = useSelector((state) => state.addwallet.open);
  const dispatch = useDispatch();
  const initialValues = {
    wallet: "",
    walletname: "",
    walletaddress: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});
  const [isValid, setValid] = useState(false);

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues((formValues) => {
      setformErrors((errors) => {
        return {
          ...errors,
          [name]: handleValidation({ ...formValues, [name]: value }).errors[
            name
          ],
        };
      });
      return { ...formValues, [name]: value };
    });
  };
  const handleValidation = (values) => {
    const errors = {};

    let isValid = true;

    errors.walletaddress = walletnameValidation(
      values.walletaddress,
      "Wallet address"
    );
    errors.country = countryValidation(values.country);
    setValid(!Object.values(errors).some(Boolean));
    return {
      isValid,
      errors,
    };
  };
  const handleSubmit = async (e) => {
    e.preventDefault();
    const { errors, isValid } = handleValidation(formValues);

    if (!isValid) {
      setformErrors(errors);
    }
    if (!Object.values(formValues).includes("")) {
      formValues.id = formValues.id === undefined ? Date.now() : formValues.id;
      setformValues({ ...formValues });
    }
  };

  const handleSetTrigger = () => {
    dispatch(closePopup());
  };

  return (
    <div>
      <form onSubmit={handleSubmit} onInput={handleChanges}>
        <Popup
          trigger={open}
          // buttonOnclick={handleSubmit}
          setTrigger={handleSetTrigger}
          disabled={!isValid}
          buttonLable="Done"
        >
          <div className="d-flex justify-content-between">
            <h4>Wallet</h4>
            <RiCloseLine
              size="30px"
              cursor="pointer"
              onClick={() => handleSetTrigger(false)}
            />
          </div>

          <Select
            name="country"
            className="form-control"
            label="Coin"
            value={formValues.country}
            options={[
              { label: "" },
              { label: "BitCoin", value: 1 },
              { label: "Ethereum", value: 2 },
            ]}
            formErrors={formErrors}
          />

          <WalletName
            name="walletaddress"
            placeholder="Wallet Address "
            label="Wallet Address"
            value={formValues.walletaddress}
            formErrors={formErrors}
          />
          <WalletName
            name="walletname"
            placeholder="Wallet Name"
            label="Wallet Name"
            value={formValues.walletname}
          />
        </Popup>
      </form>
    </div>
  );
}

export default AddWallet;
