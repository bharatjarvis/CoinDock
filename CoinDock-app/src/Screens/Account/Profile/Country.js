import React, { useState } from "react";
import { useCountry } from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import { useAccount } from "App/Api/accapi";
import { useAccountData } from "App/Api/accapi";
import { countryValidation } from "Shared/Form/Select/Select";
function Country() {
  const { data: account } = useAccount();
  const accountDetails = account?.data?.results?.user || {};
  const [formErrors, setformErrors] = useState({});
  const initialValues = {
    country: accountDetails.country,
  };
  const { data: countryfilter } = useCountry();
  const [formValues, setformValues] = useState(initialValues);
  const [isValid, setValid] = useState(false);
  const [filter, setFilter] = useState({});
  const [getData] = useAccountData();
  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
    handleValidation({ ...formValues, [name]: value });
  };
  const navigate = useNavigate();
  const handleValidation = (values) => {
    const errors = {};
    errors.country = countryValidation(values.country);
    const isValid = !Object.values(errors).some(Boolean);
    setformErrors(errors);
    setValid(isValid);
    return {
      isValid,
      errors,
    };
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
          navigate("/profile-settings");
        });
    }
  };
  return (
    <div className="container-2 col py-5">
      <h3>Edit Country</h3>
      <form onInput={handleChanges}>
        <select
          className="form-control cd-select cd-mt-8"
          name="country"
          onChange={handleChange}
          defaultValue={formValues.country}
          label="Country"
        >
          {countryfilter?.data?.results?.countries?.map((value) => {
            return (
              <option value={value} key={value}>
                {value}
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
export default Country;
