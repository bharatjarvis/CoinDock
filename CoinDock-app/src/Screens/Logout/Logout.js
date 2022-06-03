import { Navbar, Nav, NavDropdown, Button } from "react-bootstrap";
import React, { useState } from "react";
import "./Logout.css";
import { Link } from "react-router-dom";
import { useLogout } from "../../App/Api/auth";
import { useNavigate } from "react-router-dom";
import Search from "../../Shared/Search/Search";
import Select from "../../Shared/Form/Select";
import Popup from "../Popup/Popup";
import Section from "../../Shared/Section2/Section";
import Name from "../../Shared/Form/Name/Name";
import "../../Shared/common-styles/space.css";
import { RiCloseLine } from "react-icons/ri";
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

        <Nav.Link href="#addwallet">
          <p
            className="cd-addwallet-button cd-mt-19 cd-mb-25 cd-ml-8"
            onClick={() => setButtonPopup(true)}
          >
            AddWallet
          </p>
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
                  className="nav-link dropdown-toggle rounded-circle cd-ml-12 cd-mt-17 cd-mb-23 cd-mr-8"
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
      <Popup
        trigger={buttonPopup}
        setTrigger={setButtonPopup}
        buttonLable="Done"
      >
        <div className="d-flex justify-content-between">
          <h4>Wallet</h4>
          <RiCloseLine
            size="30px"
            cursor="pointer"
            onClick={() => setButtonPopup(false)}
          />
        </div>

        <Select
          name="Wallet"
          className="form-control"
          label="Wallet"
          options={[
            { label: "" },
            { label: "BitCoin", value: 1 },
            { label: "Ethereum", value: 2 },
          ]}
          formErrors={formErrors}
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
