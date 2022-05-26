import React, { useEffect, useState } from "react";
import "./SignUp.css";
import Name from "../../Shared/Form/Name/Name.js";
import Email from "../../Shared/Form/Email/Email.js";
import Popup from "../Popup/Popup.js";
import "bootstrap/dist/css/bootstrap.min.css";
import { emailValidation } from "../../Shared/Form/Email/Email.js";
import "../../Shared/common-styles/common.css";
import Stepper from "../../Shared/Form/Ellipse/Stepper";
import { usePostRegisterMutation } from "../../App/Api/signup";
import Select from "../../Shared/Form/Select";
import DatePick from "../../Shared/Date/DatePick";
import { nameValidation } from "../../Shared/Form/Name/Name.js";
import Password from "../../Shared/Password/Password";
import { passwordValidation } from "../../Shared/Password/Password";
import { reenterpasswordValidation } from "../../Shared/Password/Password";

function SignUP(props) {
  const [buttonPopup, setButtonPopup] = useState(false);
  const [register, { error }] = usePostRegisterMutation();
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

  const handleChanges = (e) => {
    console.log(e);
    const { name, value } = e.target;
    setformValues((formValues) => {
      console.log({ ...formValues, [name]: value });
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
        await register(formValues).unwrap();
        setButtonPopup(true);
      } catch (errorResponse) {
        setformErrors({});
      }
    }

    if (!Object.values(formValues).includes("")) {
      formValues.id = formValues.id === undefined ? Date.now() : formValues.id;
      setformValues({ ...formValues });
    }
  };

  const handleValidation = (values) => {
    const errors = {};

    let isValid = true;
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
    errors.firstname = nameValidation(values.firstname, "First Name");
    errors.lastname = nameValidation(values.lastname, "Last Name");
    errors.email = emailValidation(values.email);
    errors.password = passwordValidation(values.password, "Password ");
    errors.password = passwordValidation(values.password, "Password ", "12");
    errors.reenterpassword = reenterpasswordValidation(
      values.reenterpassword,
      "Password",
      values.password
    );
    // errors.reenterpassword = reenterpasswordValidation(
    //   values.reenterpassword,
    //   "Password",
    //   values.password
    // );
    if (!values.date) {
      console.log(values, values.date);
      isValid = false;
      errors.date = "Date of birth is required";
    }
    if (!values.country) {
      isValid = false;
      errors.country = "Country is required";
    }
    // if (!values.password) {
    //   isValid = false;
    //   errors.password = "Password is required";
    // } else if (values.password.length < 12) {
    //   errors.password = "Password must be more than 12 characters!!!";
    // }
    // if (!values.reenterpassword) {
    //   isValid = false;
    //   errors.reenterpassword = "Re enter the Password";
    // }
    // if (values.password !== values.reenterpassword) {
    //   errors.reenterpassword = "Password is not matching";
    // }

    setValid(isValid);
    return {
      isValid,
      errors,
    };
  };

  useEffect(() => {}, [isValid]);

  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div className="col-12  my-4">
            <div style={{ minWidth: "30vw" }}>
              <div className="d-flex justify-content-between"></div>
              <Stepper totalSteps={3} />

              <form onSubmit={handleSubmit} onInput={handleChanges}>
                <div>
                  <Name
                    name="firstname"
                    placeholder="First Name"
                    label="First Name"
                    value={formValues.firstname}
                  />
                  <p className="text-danger">{formErrors.firstname}</p>
                  <Name
                    name="lastname"
                    placeholder="Last Name"
                    label="Last Name"
                    value={formValues.lastname}
                  />
                  <p className="text-danger">{formErrors.lastname}</p>
                </div>

                <label>Date of Birth</label>
                <DatePick name="date" onChange={handleChanges} />
                <div>
                  <p className="text-danger">{formErrors.date}</p>
                </div>

                <Email />
                <p className="text-danger">{formErrors.email}</p>
                <div>
                  <Select
                    name="country"
                    label="Country"
                    value={formValues.country}
                    options={[
                      { label: "" },
                      { label: "India", value: 1 },
                      { label: "Pakistan", value: 2 },
                    ]}
                  />
                  <p className="text-danger">{formErrors.country}</p>
                </div>
                <div>
                  <Password
                    name="password"
                    placeholder="Password"
                    label="Password"
                    value={formValues.password}
                  />
                  <p className="text-danger">{formErrors.password}</p>
                  <Password
                    name="reenterpassword"
                    placeholder="Re-enter Password"
                    label="Re-enter Password"
                    value={formValues.reenterpassword}
                  />
                  <p className="text-danger">{formErrors.reenterpassword}</p>
                </div>

                {/* <label>Password</label> */}
                {/* <input
                  type="password"
                  className="form-control mt-3 py-8"
                  name="password"
                  placeholder="Password"
                  value={formValues.password}
                  onChange={handleChanges}
                />
                <p className="text-danger">{formErrors.password}</p>
                <label>Re-enter password</label>
                <input
                  type="password"
                  className="form-control"
                  name="reenterpassword"
                  placeholder="Re-enter Password"
                  value={formValues.reenterpassword}
                  onChange={handleChanges}
                />
                <p className="text-danger">{formErrors.reenterpassword}</p> */}
                <p className="condition">
                  By clicking on confirm, you agreed to the CoinDock terms and
                  conditions
                </p>
                <div className="d-flex justify-content-end">
                  <button className="confirms" disabled={!isValid}>
                    confirm
                  </button>
                  <Popup trigger={buttonPopup} setTrigger={setButtonPopup}>
                    <h5>Account recovery information</h5>
                    <img className="image" />
                    <p className="para">
                      We’re going to display the account recovery information on
                      the next screen. Please ensure that you have good internet
                      connection and no individual is watching.
                    </p>
                  </Popup>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default SignUP;
