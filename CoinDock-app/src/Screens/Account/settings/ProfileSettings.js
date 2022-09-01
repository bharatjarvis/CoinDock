import React from "react";
import "../Account.css";
import moment from "moment";
import { useAccount } from "App/Api/accapi";
import { FaEdit } from "react-icons/fa";
import { FaArrowLeft } from "react-icons/fa";
import "../../../Shared/common-styles/button.css";
import { useNavigate } from "react-router-dom";
import { Card } from "react-bootstrap";

function ProfileSettings() {
  const { data: account, message } = useAccount();
  const accountDetails = account?.data?.results?.user || {};
  const navigate = useNavigate();
  const fields = [
    {
      label: "Name",
      fieldKey: "name",
      navigate: "/profile-name",
    },
    {
      label: "Date-of-Birth",
      fieldKey: "dob",
      navigate: "/profile-dob",
    },
    {
      label: "Country",
      fieldKey: "country",
      navigate: "/profile-country",
    },
  ];

  const date = moment(accountDetails.date_of_birth).format("DD-MM-YYYY");

  return (
    <div>
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
        Profile settings
      </h2>
      {fields.map((field, id) => (
        <div className="cd-card1" key={id}>
          {field.navigate ? (
            <Card className="cd-cardstyle bg-light mb-3">
              <Card.Body className="d-flex justify-content-between">
                {field.label} :
                {field.fieldKey == "name"
                  ? accountDetails.first_name + " " + accountDetails.last_name
                  : field.fieldKey == "dob"
                  ? date
                  : field.fieldKey == "country"
                  ? accountDetails.country
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
    </div>
  );
}
export default ProfileSettings;
