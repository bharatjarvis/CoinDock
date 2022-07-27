import React, { useState } from "react";
import { RiCloseLine } from "react-icons/ri";
import Select from "Shared/Form/Select";

import Popup from "Shared/Popup/Popup";

import { useSelector, useDispatch } from "react-redux";
import { closePopup } from "Screens/AddWallet/AddWalletSlice";
import { walletnameValidation } from "Shared/Form/WalletFields/WalletName";
import WalletName from "Shared/Form/WalletFields/WalletName";
import { countryValidation } from "Shared/Form/Select/Select";
import { useAddWalletMutation, useCoins } from "App/Api/walletapi";

function AddWallet() {
  const open = useSelector((state) => state.addwallet.open);

  const { data: coins } = useCoins();

  const [wallet] = useAddWalletMutation();

  const dispatch = useDispatch();
  const initialValues = {
    coin: "",
    walletname: "",
    wallet_id: "",
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

    errors.wallet_id = walletnameValidation(values.wallet_id, "Wallet id");
    errors.coin = countryValidation(values.coin, "Coin");
    setValid(!Object.values(errors).some(Boolean));
    return {
      isValid,
      errors,
    };
  };
  const handleSubmit = async () => {
    // e.preventDefault();
    const { errors, isValid } = handleValidation(formValues);

    if (!isValid) {
      setformErrors(errors);
    } else {
      try {
        await wallet({ ...formValues }).unwrap();

        setformValues(initialValues);
      } catch (errorResponse) {}
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
          buttonOnclick={handleSubmit}
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
            name="coin"
            className="form-control"
            label="Coin*"
            value={formValues.coin}
            options={(coins?.data?.results?.coins ?? []).map((value) => {
              return { label: value.coin_id, value: value.coin_id };
            })}
            formErrors={formErrors}
            emptyPlaceHolder={true}
          />

          <WalletName
            name="wallet_id"
            placeholder="Wallet Address "
            label="Wallet Address*"
            value={formValues.wallet_id}
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
