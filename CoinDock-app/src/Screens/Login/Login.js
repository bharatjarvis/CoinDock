import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./Login.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "Shared/common-styles/button.css";
import { useLogin } from "App/Api/auth";

function Login() {
  let navigate = useNavigate();
  const [login] = useLogin();
  const initialValues = { email: "", password: "" };
  const [formValues, setformValues] = useState(initialValues);
  const [formErrors, setformErrors] = useState({});
  const [isShow] = useState(false);

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setformValues({ ...formValues, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    setformErrors(handleValidation(formValues));

    login({
      ...formValues,
    })
      .unwrap()
      .then(() => {
        navigate("/logout");
      });
  };

  const handleValidation = (values) => {
    const errors = {};
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i;
    if (!values.email) {
      errors.email = "Email is required!";
    } else if (!regex.test(values.email)) {
      errors.email = "This is not a valid email format!";
    }
    if (!values.password) {
      errors.password = "Password is required";
    } else if (values.password.length < 12) {
      errors.password = "Password must be more than 12 characters";
    }
    return errors;
  };
  return (
    <div className="row content d-flex justify-content-center align-items-center">
      <div className="col-md-3">
        <h3 className="nm-4 text-center fs-1 m-4">Login</h3>

        <form className="mb-3" onSubmit={handleSubmit}>
          <div className="form-group mb-3">
            <label>Email</label>
            <input
              type="email"
              name="email"
              className="form-control mt-1 py-8"
              placeholder="Enter your email address"
              value={formValues.email}
              id="email"
              onChange={handleChanges}
            />
          </div>
          <p className="text-danger">{formErrors.email}</p>
          <div className="form-group mb-3">
            <label>Password</label>
            <input
              type={isShow ? "text" : "password"}
              name="password"
              className="form-control mt-1 py-8"
              placeholder="Enter your password"
              value={formValues.password}
              id="password"
              onChange={handleChanges}
              data-toggle="password"
            />
          </div>
          <p className="text-danger">{formErrors.password}</p>
          {/* <div className="d-grid gap-2">
            <button className="btn btn-primary btn-lg border-0">Login</button>
          </div> */}
          <div className="d-flex justify-content-end">
            <button
              className="cd-button cd-button-2 cd-login-button"
              type="submit"
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
