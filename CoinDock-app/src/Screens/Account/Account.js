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

  const accordianBasedAccountDetails = [
    {
      label: "Profile settings",
      key: "profile",
      navigate: "/profile-settings",
    },
    {
      label: "Account settings",
      key: "accounts",
      navigate: "/account-settings",
    },
    {
      label: "System settings",
      key: "system",
      navigate: "/system-settings",
    },
  ];

  const handleLogoutClick = async () => {
    try {
      await logout().unwrap();
      navigate("/");
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
                {item.navigate ? (
                  <Card
                    className="cd-cardstyle bg-light mb-3"
                    onClick={() => {
                      navigate(item.navigate);
                    }}
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
