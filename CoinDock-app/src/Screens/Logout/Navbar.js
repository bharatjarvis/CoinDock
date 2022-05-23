import { Navbar, Nav, NavDropdown } from "react-bootstrap";
import { Link } from "react-router-dom";
import "./Navbar.css";

function Header() {
  return (
    <div>
      <Navbar variant="dark" className="start">
        <Navbar.Brand href="#home">CoinDock</Navbar.Brand>
        <Nav>
          <NavDropdown title="User Name" className="profile">
            <NavDropdown.Item>Logout</NavDropdown.Item>
          </NavDropdown>
        </Nav>
      </Navbar>
    </div>
  );
}

export default Header;
