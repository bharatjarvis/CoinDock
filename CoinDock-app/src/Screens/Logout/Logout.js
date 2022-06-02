import {
  Navbar,
  Nav,
  NavDropdown,
  Button,
  Container,
  Form,
  FormControl,
} from "react-bootstrap";
import React, { useState } from "react";
import "./Logout.css";
import { Link } from "react-router-dom";
import { useLogout } from "../../App/Api/auth";
import { useNavigate } from "react-router-dom";
import Search from "../../Shared/Dashboard/Search";
import Select from "../../Shared/Form/Select";
import Popup from "../Popup/Popup";
import Section from "../../Shared/Section2/Section";
import Name from "../../Shared/Form/Name/Name";
function Logout() {
  const navigate = useNavigate();
  const [buttonPopup, setButtonPopup] = useState(false);
  const [formErrors, setformErrors] = useState({});
  const [logout] = useLogout();
  const handleLogoutClick = async () => {
    try {
      await logout().unwrap();
      navigate("/login");
    } catch (e) {
      navigate("/login");
    }
  };

  return (
    <React.Fragment>
      <Navbar variant="dark" className="start">
        <Navbar.Brand href="#home">CoinDock</Navbar.Brand>
        <Search />

        <Nav.Link href="#addwallet" className="nav-link">
          <Button onClick={() => setButtonPopup(true)}>Add Wallet</Button>
        </Nav.Link>
        <Nav>
          <NavDropdown
            title={
              <div className="pull-left">
                <img
                  src="https://i.stack.imgur.com/34AD2.jpg"
                  width="50"
                  height="50"
                  alt="profile_icon"
                  className="nav-link dropdown-toggle rounded-circle"
                  style={{ cursor: "pointer" }}
                  data-bs-toggle="dropdown"
                ></img>
              </div>
            }
          >
            <NavDropdown.Item onClick={handleLogoutClick} className="cd-logout">
              Logout
            </NavDropdown.Item>
          </NavDropdown>
        </Nav>
      </Navbar>
      <Popup trigger={buttonPopup} setTrigger={setButtonPopup}>
        <Select
          name="Wallet"
          className="form-control"
          label="Wallet"
          options={[
            { label: "" },
            { label: "BitCoin", value: 1 },
            { label: "Ethereum", value: 2 },
          ]}
        />

        <Name
          name="Wallet Address"
          placeholder="Wallet Address "
          label="Wallet Address"
          formErrors={formErrors}
        />
        <Name
          name="Wallet Name"
          placeholder="Wallet Name"
          label="Wallet Name"
          formErrors={formErrors}
        />
      </Popup>
      <div className="cd-performance-wrap">
        <Section name="Total BTC" value=" ₿0.00001033" />
        <Section name="Total Primary Currency" value="$26.72" />
        <Section name="Top Performer" value="BTC" />
        <Section name="Low Performer" value="Ethereum" />
      </div>
    </React.Fragment>
  );
}

export default Logout;
