import React, { useState } from "react";
import "./SignUp.css";
import Name from "Shared/Form/Name/Name.js";
import Email from "Shared/Form/Email/Email.js";
import Popup from "../../Shared/Popup/Popup.js";
import "bootstrap/dist/css/bootstrap.min.css";
import { emailValidation } from "Shared/Form/Email/Email.js";
import "Shared/common-styles/common.css";
import Stepper from "Shared/Form/Ellipse/Stepper";
import { usePostRegisterMutation } from "App/Api/signup";
import Select from "Shared/Form/Select";
import DatePick, { dateValidation } from "Shared/Date/DatePick";
import { nameValidation } from "Shared/Form/Name/Name";
import Password from "Shared/Password/Password";
import { passwordValidation } from "Shared/Password/Password";
import { reenterpasswordValidation } from "Shared/Password/Password";
import { countryValidation } from "Shared/Form/Select/Select";
import "Shared/common-styles/button.css";
import { useNavigate } from "react-router-dom";
import { useRefresh } from "App/Api/auth";
import Lock from "Shared/images/Lock.png";
import { useCountry } from "App/Api/accapi";
function SignUP(props) {
  const navigate = useNavigate();
  const [refresh] = useRefresh();
  const [buttonPopup, setButtonPopup] = useState(false);
  const { data: countryfilter } = useCountry();
  const [register] = usePostRegisterMutation();
  const [isValid, setValid] = useState(false);
  const initialValues = {
    firstname: "",
    lastname: "",
    date: "",
    email: "",
    country: "",
    password: "",

    reenterpassword: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});
  const [filter, setFilter] = useState({});
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
  const handleSubmit = async (e) => {
    e.preventDefault();
    const { errors, isValid } = handleValidation(formValues);

    if (!isValid) {
      setformErrors(errors);
    } else {
      try {
        await register({ ...formValues })
          .unwrap()
          .then(() => {
            setButtonPopup(true);
          });
      } catch (errorResponse) {
        const {
          first_name,
          last_name,
          date_of_birth,
          country,
          email,
          password,
        } = errorResponse?.data?.errors ?? {};
        setformErrors({
          firstname: first_name,
          lastname: last_name,
          date: date_of_birth,
          email,
          country,
          password,
        });
      }
    }
  };

  const handleValidation = (values) => {
    const errors = {};

    let isValid = true;

    errors.firstname = nameValidation(values.firstname, "First Name", 45);
    errors.lastname = nameValidation(values.lastname, "Last Name", 45);
    errors.email = emailValidation(values.email);
    errors.password = passwordValidation({
      value: values.password,
      label: "Password ",
      minlength: 12,
      maxlength: 45,
    });
    errors.reenterpassword = reenterpasswordValidation(
      values.reenterpassword,
      "Password",
      values.password
    );
    errors.date = dateValidation(values.date);
    errors.country = countryValidation(values.country, "Country");

    setValid(!Object.values(errors).some(Boolean));
    return {
      isValid,
      errors,
    };
  };
  const handleChange = (e) => {
    setFilter(e.target.value);
  };
  const handleSuccessPopupButtonClick = () => {
    refresh()
      .unwrap()
      .then(() => {
        navigate("/recovery-codes");
      });
  };
  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div className="col-12  my-4">
            <div style={{ minWidth: "30vw" }}>
              <div className="d-flex justify-content-between"></div>
              <Stepper totalSteps={3} />

              <form
                onSubmit={handleSubmit}
                onInput={handleChanges}
                className="cd-padding-14"
              >
                <div>
                  <Name
                    name="firstname"
                    placeholder="First Name"
                    label="First Name"
                    value={formValues.firstname}
                    formErrors={formErrors}
                  />

                  <Name
                    name="lastname"
                    placeholder="Last Name"
                    label="Last Name"
                    value={formValues.lastname}
                    formErrors={formErrors}
                  />
                </div>

                <DatePick
                  name="date"
                  value={formValues.date}
                  formErrors={formErrors}
                  onChange={handleChanges}
                />
                <Email
                  name="email"
                  value={formValues.email}
                  formErrors={formErrors}
                />

                <div>
                  <Select
                    name="country"
                    label="Country"
                    onChange={handleChange}
                    defaultValue={formValues.country}
                    formErrors={formErrors}
                    emptyPlaceHolder={true}
                    options={(
                      countryfilter?.data?.results?.countries ?? []
                    ).map((value) => ({
                      label: value,
                      key: value,
                    }))}
                  />
                </div>
                <div>
                  <Password
                    name="password"
                    placeholder="Password"
                    label="Password"
                    value={formValues.password}
                    formErrors={formErrors}
                  />

                  <Password
                    name="reenterpassword"
                    placeholder="Re-enter Password"
                    label="Re-enter Password"
                    value={formValues.reenterpassword}
                    formErrors={formErrors}
                  />
                </div>

                <p className="condition cd-mt-12">
                  By clicking on confirm, you agree to the CoinDock terms and
                  conditions
                </p>
                <div className="d-flex justify-content-end">
                  <button
                    className="cd-button cd-button-2"
                    disabled={!isValid}
                    type="submit"
                  >
                    confirm
                  </button>
                </div>
              </form>
              <Popup
                trigger={buttonPopup}
                setTrigger={() => {
                  handleSuccessPopupButtonClick();
                }}
                buttonLable="OK"
              >
                <h5 className="cd-account-heading">
                  Account recovery information
                </h5>
                <div className="p-3">
                  <img className="cd-lock-image" src={Lock} alt="Lock" />
                </div>
                <p className="para">
                  We’re going to display the account recovery information on the
                  next screen. Please ensure that you have good internet
                  connection and no individual is watching.
                </p>
              </Popup>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default SignUP;
