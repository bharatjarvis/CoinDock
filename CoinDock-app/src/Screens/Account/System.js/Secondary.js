import React, { useState } from "react";
import { useCurrency } from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import { useAccountData } from "App/Api/accapi";
function Secondary() {
  const [, setformErrors] = useState({});
  const initialValues = {
    secondary_currency: "",
  };
  const navigate = useNavigate();
  const { data: currencyfilter } = useCurrency();
  const [formValues, setformValues] = useState(initialValues);
  const [isValid, setValid] = useState(false);
  const [, setFilter] = useState({});
  const [getData] = useAccountData();
  const handleChanges = (e) => {
    const { name, value } = e.target;
    handleValidation({ ...formValues, [name]: value });
    setformValues({ ...formValues, [name]: value });
  };

  const handleChange = (e) => {
    setFilter(e.target.value);
  };
  const handleSubmit = () => {
    const { errors, isValid } = handleValidation(formValues);
    if (!isValid) {
      setformErrors(errors);
    } else {
      getData({
        ...formValues,
      })
        .unwrap()
        .then(() => {
          navigate("/system-settings");
        });
    }
  };
  const handleValidation = (values) => {
    const errors = {};
    const isValid = !Object.values(errors).some(Boolean);
    setformErrors(errors);
    setValid(isValid);
    return {
      isValid,
      errors,
    };
  };

  return (
    <div className="container-2 col py-5">
      <h3>Edit secondary currency</h3>
      <form onInput={handleChanges}>
        <select
          className="form-control cd-select cd-mt-8"
          name="secondary_currency"
          onChange={handleChange}
          label="Secondary Currency"
        >
          {currencyfilter?.data?.results?.coins?.map((value, id) => {
            return (
              <option value={value.coin_id} key={id}>
                {value.coin_id}
              </option>
            );
          })}
        </select>
      </form>
      <div className="cd-edit-style">
        <button
          className="cd-button-2"
          disabled={!isValid}
          onClick={handleSubmit}
        >
          Submit
        </button>
      </div>
    </div>
  );
}
export default Secondary;
