import React from "react";
import "../Account.css";
import ArrowBackIosIcon from "@mui/icons-material/ArrowBackIos";
import { Typography } from "@mui/material";
import { FaArrowLeft } from "react-icons/fa";
import { FaEdit } from "react-icons/fa";
import "../../../Shared/common-styles/button.css";
import { useAccount } from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import { Card } from "react-bootstrap";
import { CardContent } from "@mui/material";
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
      <ArrowBackIosIcon
        type="submit"
        style={{ maxWidth: 45, marginTop: "35px" }}
        onClick={() => {
          navigate("/account");
        }}
      />{" "}
      <Typography
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
      </Typography>
      {fields.map((field, id) => (
        <div className="cd-card1" key={id}>
          {field.displayLabel ? (
            <Card className="cd-cardstyle bg-light mb-3">
              <CardContent className="d-flex justify-content-between">
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
              </CardContent>
            </Card>
          ) : (
            <Card className="cd-cardstyle bg-light mb-3">
              <CardContent className="d-flex justify-content-between">
                {field.label} : {accountDetails.email}
              </CardContent>
            </Card>
          )}
        </div>
      ))}
    </>
  );
}
export default AccountSettings;
