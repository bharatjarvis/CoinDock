import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

import "./Login.css";
import "bootstrap/dist/css/bootstrap.min.css";

import { emailValidation } from "Shared/Form/Email/Email.js";
import Password from "Shared/Password/Password";
import "Shared/common-styles/button.css";
import { useLogin } from "App/Api/auth";
import "Shared/Password/Password.css";
import { requiredValidation } from "Shared/Validation/requiredValidation";

import { Card } from "react-bootstrap";
import { Link } from "react-router-dom";
import Email from "Shared/Form/Email";
function Login() {
  let navigate = useNavigate();
  const [login, loginOptions] = useLogin();
  const initialValues = { email: "", password: "" };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});
  const [displayErrorMessage, setDisplayErrorMessage] = useState(false);

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

  const handleSubmit = (e) => {
    e.preventDefault();

    const { errors, isValid } = handleValidation(formValues);
    if (!isValid) {
      setformErrors(errors);
    } else {
      login({
        ...formValues,
      })
        .unwrap()
        .then(() => {
          navigate("/dashboard");
        })
        .catch(() => {
          setDisplayErrorMessage(true);
        });
    }
    if (!Object.values(formValues).includes("")) {
      formValues.id = formValues.id === undefined ? Date.now() : formValues.id;
      setformValues({ ...formValues });
    }
  };

  const handleValidation = (values) => {
    const errors = {};

    let isValid = true;
    errors.email = emailValidation(values.email);
    errors.password = requiredValidation({
      value: values.password,
      label: "Password ",
    });
    setValid(!Object.values(errors).some(Boolean));
    return {
      isValid,
      errors,
    };
  };
  const handleOnFocus = () => {
    if (displayErrorMessage) setDisplayErrorMessage(false);
  };

  return (
    <div className="row content d-flex justify-content-center align-items-center">
      <div className="col-md-3">
        <h2 className="text-center fs-4 m-4">Login</h2>

        <span>
          Don’t have an account?
          <Link to="/signup">Signup here!</Link>
        </span>

        {Boolean(loginOptions?.isError) && displayErrorMessage && (
          <p className="cd-login-error">{loginOptions?.error?.data?.message}</p>
        )}

        <form
          className="mb-3"
          onSubmit={handleSubmit}
          onFocus={handleOnFocus}
          onInput={handleChanges}
        >
          <div className="form-group mb-3">
            <Email name="email" value={formValues.email} />
          </div>
          <p className="text-danger">{formErrors.email}</p>
          <div className="form-group mb-3">
            <div>
              <Password
                name="password"
                placeholder="Password"
                label="Password"
                value={formValues.password}
              />
            </div>
            <p className="text-danger">{formErrors.password}</p>
          </div>

          <div className="d-flex justify-content-end">
            <button
              className="cd-button cd-button-2 cd-login-button"
              type="submit"
              disabled={!isValid}
            >
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}

export default Login;
