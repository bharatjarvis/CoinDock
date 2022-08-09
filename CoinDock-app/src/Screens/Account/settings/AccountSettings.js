import React from "react";
import "../Account.css";
import { FaArrowLeft } from "react-icons/fa";
import { FaEdit } from "react-icons/fa";
import "../../../Shared/common-styles/button.css";
import { useAccount } from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import { Card } from "react-bootstrap";

function AccountSettings() {
  const { data: account } = useAccount();
  const accountDetails = account?.data?.results?.user || {};
  const navigate = useNavigate();
  const fields = [
    {
      label: "Email",
      key: "email",
    },
    {
      label: "Change Password",
      displayLabel: "Change Password",
      key: "changepassword",
      navigate: "/account-password",
    },
    {
      label: "Recovery Code",
      displayLabel: "Recovery Code",
      key: "recoverycodes",
      navigate: "/recovery-codes-account",
    },
  ];

  return (
    <>
      <FaArrowLeft
        type="submit"
        style={{ maxWidth: 45, marginTop: "35px" }}
        onClick={() => {
          navigate("/account");
        }}
      />{" "}
      <h2
        style={{
          textAlign: "center",
          fontWeight: "lighter",
          fontFamily: "monospace",
          marginTop: "-30px",
          marginBottom: "10px",
        }}
        variant="h4"
      >
        Account settings
      </h2>
      {fields.map((field, id) => (
        <div className="cd-card1" key={id}>
          {field.displayLabel ? (
            <Card className="cd-cardstyle bg-light mb-3">
              <Card.Body className="d-flex justify-content-between">
                {field.label}
                {field.key == "changepassword" ? (
                  <span
                    type="submit"
                    style={{ float: "end" }}
                    onClick={() => {
                      navigate(field.navigate);
                    }}
                  >
                    <FaEdit />
                  </span>
                ) : field.key == "recoverycodes" ? (
                  <button
                    onClick={() => {
                      navigate(field.navigate);
                    }}
                    className="cd-card-button1"
                  >
                    Re-Generate
                  </button>
                ) : null}
              </Card.Body>
            </Card>
          ) : (
            <Card className="cd-cardstyle bg-light mb-3">
              <Card.Body className="d-flex justify-content-between">
                {field.label} : {accountDetails.email}
              </Card.Body>
            </Card>
          )}
        </div>
      ))}
    </>
  );
}
export default AccountSettings;
