import React, { useState } from "react";
import { useAccountData } from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import { useAccount } from "App/Api/accapi";
import DatePick, { dateValidation } from "Shared/Date/DatePick";
function DateofBirth() {
  const { data: account } = useAccount();
  const accountDetails = account?.data?.results?.user || {};
  const [formErrors, setformErrors] = useState({});
  const initialValues = {
    date_of_birth: accountDetails.date_of_birth,
  };
  const navigate = useNavigate();
  const [formValues, setformValues] = useState(initialValues);
  const [isValid, setValid] = useState(false);
  const [getData] = useAccountData();
  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
    handleValidation({ ...formValues, [name]: value });
  };
  const handleValidation = (values) => {
    const errors = {};
    errors.date_of_birth = dateValidation(values.date_of_birth);
    const isValid = !Object.values(errors).some(Boolean);
    setformErrors(errors);
    setValid(isValid);
    return {
      isValid,
      errors,
    };
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
      <h3>Edit Date-of-birth</h3>
      <form onInput={handleChanges}>
        <DatePick
          name="date_of_birth"
          value={formValues.date_of_birth}
          formErrors={formErrors}
        />
      </form>
      <div className="cd-edit-style">
        <button
          className="cd-button-2 cd-button "
          disabled={!isValid}
          onClick={handleSubmit}
        >
          Submit
        </button>
      </div>
    </div>
  );
}
export default DateofBirth;
