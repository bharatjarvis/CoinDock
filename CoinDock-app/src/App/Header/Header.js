import React from "react";
import { Navbar, Nav, NavDropdown } from "react-bootstrap";
import "./Header.css";
import { useLocation, useNavigate } from "react-router-dom";
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
  const location = useLocation();

  const notDisplayAuthenticatedOptions = ["/recovery-codes", "/recovery-test"];

  const [logout] = useLogout();
  const dispatch = useDispatch();

  const handleLogoutClick = async () => {
    try {
      await logout().unwrap();
      navigate("/login");
    } catch (e) {
      navigate("/");
    }
  };
  const handleAccountClick = () => {
    navigate("/account");
  };
  return (
    <React.Fragment>
      <div className="cd-header-dimensions">
        <Navbar variant="dark" className="cd-app-header cd-header-dimensions">
          <Navbar.Brand href="/dashboard">
            <img className="cd-logo-image" src={Logo2} alt="Lock Images" />{" "}
            <span> &nbsp; CoinDock </span>
          </Navbar.Brand>
          {isAuthenticated &&
            !notDisplayAuthenticatedOptions.includes(location.pathname) && (
              <>
                <Search />
                <Nav.Link>
                  <p
                    className="cd-addwallet-button cd-mt-19 cd-mb-25 cd-ml-8"
                    onClick={() => dispatch(openPopup())}
                  >
                    Add&nbsp;Wallet
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
      </div>
    </React.Fragment>
    // <div className="myContainer">
    //   <Navbar
    //     id="navbar"
    //     className="cd-app-header cd-header-dimensions"
    //     expand="lg"
    //   >
    //     <Navbar.Brand href="/">
    //       <img
    //         className="cd-logo-image"
    //         id="logo"
    //         src={Logo2}
    //         alt="Company Name"
    //       />
    //     </Navbar.Brand>
    //     <Navbar.Brand href="/dasboard">CoinDock</Navbar.Brand>
    //     <Navbar.Toggle
    //       className="custom-toggler"
    //       aria-controls="basic-navbar-nav"
    //     />
    //     <Navbar.Collapse id="basic-navbar-nav">
    //       <Nav className="ml-auto">
    //         <Nav.Link
    //           id="nav-links"
    //           className="cd-navbar-background-color"
    //           href="/cleaning-services"
    //         >
    //           Profile
    //         </Nav.Link>
    //         <hr></hr>
    //         <Nav.Link className="cd-navbar-background-color" href="#link">
    //           Profile
    //         </Nav.Link>
    //         <hr></hr>

    //         <Nav.Link className="cd-navbar-background-color" href="#link">
    //           Account
    //         </Nav.Link>
    //         <hr></hr>

    //         <Nav.Link className="cd-navbar-background-color" href="#link">
    //           Logout
    //         </Nav.Link>
    //       </Nav>
    //     </Navbar.Collapse>
    //   </Navbar>
    // </div>
  );
}

export default Header;
