import React from "react";
import "./Account.css";
import { useNavigate } from "react-router-dom";
import "Shared/common-styles/button.css";
import { useLogout } from "App/Api/auth";
import "Shared/common-styles/common.css";
import { Card } from "react-bootstrap";

function Account() {
  const [logout] = useLogout();
  const navigate = useNavigate();
  const handleCardProfile = () => {
    navigate("/profile-settings");
  };
  const handleCardAccount = () => {
    navigate("/account-settings");
  };
  const handleCardSystem = () => {
    navigate("/system-settings");
  };

  const accordianBasedAccountDetails = [
    {
      label: "Profile settings",
      key: "profile",
    },
    {
      label: "Account settings",
      key: "accounts",
    },
    {
      label: "System settings",
      key: "system",
    },
  ];

  const handleLogoutClick = async () => {
    try {
      await logout().unwrap();
      navigate("/login");
    } catch (e) {}
  };
  return (
    <div>
      <h1 style={{ marginTop: "5px", marginLeft: "42%" }}>Account</h1>
      <div className="container-11">
        <div className=" col py-5 ">
          {accordianBasedAccountDetails &&
            accordianBasedAccountDetails.map((item, id) => (
              <div key={id}>
                {item.key === "profile" ? (
                  <Card
                    type="submit"
                    className="cd-cardstyle bg-light mb-3"
                    onClick={() => {
                      handleCardProfile();
                    }}
                  >
                    <Card.Body>{item.label}</Card.Body>
                  </Card>
                ) : item.key === "accounts" ? (
                  <Card
                    type="submit"
                    onClick={() => handleCardAccount()}
                    className="cd-cardstyle bg-light mb-3"
                  >
                    <Card.Body>{item.label}</Card.Body>
                  </Card>
                ) : item.key === "system" ? (
                  <Card
                    onClick={() => handleCardSystem()}
                    className="cd-cardstyle bg-light mb-3"
                    type="submit"
                  >
                    <Card.Body>{item.label}</Card.Body>
                  </Card>
                ) : null}
              </div>
            ))}
        </div>
        <div className="d-flex justify-content-start">
          <button className="cd-button-2" onClick={handleLogoutClick}>
            Logout
          </button>
        </div>
      </div>
    </div>
  );
}
export default Account;
