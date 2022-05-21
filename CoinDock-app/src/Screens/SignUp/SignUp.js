import React, { useState } from "react";
import "./SignUp.css";
import Names from "../../Shared/Form/Names.js";
import Email from "../../Shared/Form/Email.js";

import "bootstrap/dist/css/bootstrap.min.css";
function SignUP(props) {
  const initialValues = {
    firstname: "",
    lastname: "",
    email: "",
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
    e.preventDefault();

    setformErrors(handleValidation(formValues));
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
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
    if (!values.firstname) {
      errors.firstname = "Firstname is required";
    }
    if (!values.lastname) {
      errors.lastname = "Lastname is required";
    }
    if (!values.date) {
      errors.date = "Date of birth is required";
    }
    if (!values.username) {
      errors.username = "Username is required";
    }
    if (!values.email) {
      errors.email = "Email is required";
    } else if (!regex.test(values.email)) {
      errors.email = "Email is not valid!";
    }
    if (!values.password) {
      errors.password = "Password is required";
    } else if (values.password.length < 4) {
      errors.password = "Password must be more than 4 characters!!!";
    }
    if (!values.reenterpassword) {
      errors.reenterpassword = "Re enter the Password";
    }
    return errors;
  };

  return (
    <div>
      <div className="container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div className="col-12  my-4">
            <div style={{ minWidth: "30vw" }}>
              <div className="d-flex justify-content-between"></div>
              <form>
                <div className="card shadow-sm bg-secondary p-4">
                  <Names />
                  <input
                    type="date"
                    className="form-control"
                    name="date"
                    placeholder="Date of Birth"
                    value={formValues.date}
                    onChange={handleChanges}
                  />
                  <p className="text-danger">{formErrors.date}</p>
                  <Email />

                  <select
                    id="country"
                    className="form-control mt-1 py-8"
                    placeholder="Country"
                  >
                    <option>India </option>
                    <option>Pakistan</option>
                  </select>
                  <input
                    type="password"
                    className="form-control mt-3 py-8"
                    name="password"
                    placeholder="Password"
                    value={formValues.password}
                    onChange={handleChanges}
                  />
                  <p className="text-danger">{formErrors.password}</p>
                  <input
                    type="password"
                    className="form-control"
                    name="reenterpassword"
                    placeholder="Re-enter Password"
                    value={formValues.password}
                    onChange={handleChanges}
                  />
                  <p className="text-danger">{formErrors.reenterpassword}</p>
                  <p className="condition">
                    By clicking on confirm, you agreed to he CoinDock terms and
                    conditions
                  </p>
                  <div className="d-flex justify-content-end">
                    <button
                      type="button"
                      className="btn btn-primary"
                      onClick={handleSubmit}
                    >
                      confirm
                    </button>
                  </div>
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
