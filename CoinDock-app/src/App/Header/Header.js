import React from "react";
import { Navbar, Nav, NavDropdown } from "react-bootstrap";
import "./Header.css";
import { useNavigate } from "react-router-dom";
import Search from "Shared/Search/Search";
import { useIsAuthenticated } from "App/Auth/hooks";
import { useLogout } from "App/Api/auth";
import Logo2 from "Shared/images/Logo2.png";
import AddWallet from "Screens/AddWallet/AddWallet";
import { openPopup } from "Screens/AddWallet/AddWalletSlice";
import { useDispatch } from "react-redux";
function Header() {
  const isAuthenticated = useIsAuthenticated();
  const navigate = useNavigate();

  const [logout] = useLogout();
  const dispatch = useDispatch();

  const handleLogoutClick = async () => {
    try {
      await logout().unwrap();
      navigate("/login");
    } catch (e) {
      navigate("/login");
    }
  };
  const handleAccountClick = () => {
    navigate("/account");
  };
  return (
    <React.Fragment>
      <div className="cd-header-dimensions"></div>
      <Navbar variant="dark" className="cd-app-header cd-header-dimensions">
        <Navbar.Brand href="#home">
          <img className="cd-logo-image" src={Logo2} alt="Lock Images" />
        </Navbar.Brand>
        {isAuthenticated && (
          <>
            <Search />

            <Nav.Link href="#addwallet">
              <p
                className="cd-addwallet-button cd-mt-19 cd-mb-25 cd-ml-8"
                onClick={() => dispatch(openPopup())}
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
                <NavDropdown.Item
                  onClick={handleAccountClick}
                  className="cd-account"
                >
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
      <AddWallet />
    </React.Fragment>
  );
}

export default Header;