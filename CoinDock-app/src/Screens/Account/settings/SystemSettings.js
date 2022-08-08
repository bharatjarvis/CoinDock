import React from "react";
import "../Account.css";
import { FaArrowLeft } from "react-icons/fa";
import { FaEdit } from "react-icons/fa";
import "../../../Shared/common-styles/button.css";
import { useNavigate } from "react-router-dom";
import { useAccount } from "App/Api/accapi";
import { Card } from "react-bootstrap";
function SystemSettings() {
  const { data: account } = useAccount();
  const accountDetails = account?.data?.results?.user || {};
  const navigate = useNavigate();

  const fields = [
    {
      label: "Primary currency",
      fieldKey: "primarycurrency",
      navigate: "/primary",
    },
    {
      label: "Secondary currency",
      fieldKey: "secondarycurrency",
      navigate: "/secondary",
    },
  ];
  return (
    <>
      <div
        type="submit"
        className="cd-back"
        onClick={() => {
          navigate("/account");
        }}
      >
        <FaArrowLeft />
      </div>
      <h2 className="cd-headerStyle">System settings</h2>
      {fields.map((field, id) => (
        <div className="cd-card1" key={id}>
          {field.navigate ? (
            <Card className="cd-cardstyle bg-light mb-3">
              <Card.Body className="d-flex justify-content-between">
                {field.label}:
                {field.fieldKey === "primarycurrency"
                  ? accountDetails.primary_currency +
                    " " +
                    accountDetails.primary_currency_symbol
                  : field.fieldKey === "secondarycurrency"
                  ? accountDetails.secondary_currency +
                    " " +
                    accountDetails.secondary_currency_symbol
                  : null}
                <span
                  type="submit"
                  onClick={() => {
                    navigate(field.navigate);
                  }}
                >
                  <FaEdit />
                </span>
              </Card.Body>
            </Card>
          ) : null}
        </div>
      ))}
    </>
  );
}
export default SystemSettings;
