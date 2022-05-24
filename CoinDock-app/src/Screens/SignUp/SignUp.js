import React, { useState } from "react";
import "./SignUp.css";
import Names from "../../Shared/Form/Names.js";
import Email from "../../Shared/Form/Email/Email.js";
import Popup from "../Popup/Popup.js";
import "bootstrap/dist/css/bootstrap.min.css";
import { emailValidation } from "../../Shared/Form/Email/Email.js";
import "../../Shared/common-styles/common.css";
import Stepper from "../../Shared/Form/Ellipse/Stepper";

function SignUP(props) {
  const [buttonPopup, setButtonPopup] = useState(false);
  const initialValues = {
    // firstname: "",
    // lastname: "",
    // email: "",
    country: "",
    password: "",
    date: "",
    reenterpassword: "",
  };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };

  const handleSubmit = (e) => {
    console.log("checlk");
    e.preventDefault();
    const { errors, isValid } = handleValidation(formValues);

    if (!isValid) {
      setformErrors(errors);
    } else {
      setButtonPopup(true);
    }

    if (!Object.values(formValues).includes("")) {
      formValues.id = formValues.id === undefined ? Date.now() : formValues.id;
      setformValues({ ...formValues });
      setformValues(initialValues);
      console.log("user formvalues ", formValues);
      console.log(
        formValues.id === undefined ? "error" : Date.now() + formValues.id
      );
    }
  };

  const handleValidation = (values) => {
    const errors = {};
    let isValid = true;
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
    errors.email = emailValidation(values.email);
    if (!values.firstname) {
      isValid = false;
      errors.firstname = "Firstname is required";
    }
    if (!values.lastname) {
      isValid = false;
      errors.lastname = "Lastname is required";
    }
    if (!values.date) {
      isValid = false;
      errors.date = "Date of birth is required";
    }
    if (!values.country) {
      errors.country = "Country is required";
    }
    // if (!values.email) {
    //   isValid = false;
    //   errors.email = "Email is required";
    // } else if (!regex.test(values.email)) {
    //   isValid = false;
    //   errors.email = "Email is not valid!";
    // }

    if (!values.password) {
      isValid = false;
      errors.password = "Password is required";
    } else if (values.password.length < 12) {
      errors.password = "Password must be more than 12 characters!!!";
    }
    if (!values.reenterpassword) {
      isValid = false;
      errors.reenterpassword = "Re enter the Password";
    }
    return {
      isValid,
      errors,
    };
  };

  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div className="col-12  my-4">
            <div style={{ minWidth: "30vw" }}>
              <div className="d-flex justify-content-between"></div>
              <Stepper totalSteps={3} />

              <form onSubmit={handleSubmit}>
                <div>
                  <Names />
                  <p className="text-danger">{formErrors.lastname}</p>
                </div>
                <label>Date of Birth</label>
                <div>
                  <input
                    type="date"
                    className="form-control"
                    name="date"
                    placeholder="Date of Birth"
                    value={formValues.date}
                    onChange={handleChanges}
                  />
                  <p className="text-danger">{formErrors.date}</p>
                </div>

                <Email />
                <p className="text-danger">{formErrors.email}</p>
                <div>
                  <label>Country</label>
                  <select
                    id="country"
                    className="form-control mt-1 py-8"
                    placeholder="Country"
                    onChange={handleChanges}
                  >
                    <option>Country</option>
                    <option value="1">India </option>
                    <option value="2">Pakistan</option>
                  </select>
                </div>
                <p className="text-danger">{formErrors.country}</p>
                <label>Password</label>
                <input
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
                <p className="text-danger">{formErrors.reenterpassword}</p>
                <p className="condition">
                  By clicking on confirm, you agreed to the CoinDock terms and
                  conditions
                </p>
                <div className="d-flex justify-content-end">
                  <button className="confirms">confirm</button>
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
