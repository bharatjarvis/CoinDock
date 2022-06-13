import React, { useState } from "react";
import { Navbar, Nav, NavDropdown } from "react-bootstrap";
import "./Header.css";
import { useNavigate } from "react-router-dom";
import Search from "Shared/Search/Search";
import Select from "Shared/Form/Select";
import Name from "Shared/Form/Name/Name";
import "Shared/common-styles/space.css";
import { RiCloseLine } from "react-icons/ri";
import Popup from "Screens/Popup/Popup";
import { useIsAuthenticated } from "App/Auth/hooks";
import { useLogout } from "App/Api/auth";
import Logo2 from "Shared/images/Logo2.png";
function Header() {
  const isAuthenticated = useIsAuthenticated();
  const navigate = useNavigate();
  const [buttonPopup, setButtonPopup] = useState(false);
  const [logout] = useLogout();
  
  const handleLogoutClick = async () => {
    try {
      await logout().unwrap();
      navigate("/login");
    } catch (e) {
      navigate("/login");
    }
  };
 const handleAccountClick = () =>{
  
    navigate("/account");
  
 }
  return (
    <React.Fragment>
      <div className="cd-header-dimensions"></div>
      <Navbar variant="dark" className="cd-app-header cd-header-dimensions">
        <Navbar.Brand href="#home">
          <img className="cd-logo-image" src={Logo2} alt="Lock Image" />
        </Navbar.Brand>
        {isAuthenticated && (
          <>
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
                style={{
                  zIndex: 1000,
                }}
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
                <NavDropdown.Item onClick={handleAccountClick} className="cd-account">
              Account
            </NavDropdown.Item>
                <NavDropdown.Item
                  onClick={handleLogoutClick}
                  className="cd-logout"
                >
                  Logout
                </NavDropdown.Item>
              </NavDropdown>
            </Nav>
          </>
        )}
      </Navbar>

      <form>
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
          />

          <Name
            name="Wallet Address"
            placeholder="Wallet Address "
            label="Wallet Address"
          />
          <Name
            name="Wallet Name"
            placeholder="Wallet Name"
            label="Wallet Name"
          />
        </Popup>
      </form>
    </React.Fragment>
  );
}

export default Header;
