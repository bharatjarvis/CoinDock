import { Navbar, Nav, NavDropdown } from "react-bootstrap";
import "./Logout.css";
import { useLogout } from "../../App/Api/auth";
import { useNavigate } from "react-router-dom";

function Logout() {
  const navigate = useNavigate();
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
    <div>
      <Navbar variant="dark" className="start">
        <Navbar.Brand href="#home">CoinDock</Navbar.Brand>
        <Nav>
          <NavDropdown
            title={
              <div className="pull-left">
                <img
                  src="https://i.stack.imgur.com/34AD2.jpg"
                  width="55"
                  height="55"
                  alt="profile_icon"
                  className="nav-link dropdown-toggle rounded-circle"
                  style={{ cursor: "pointer" }}
                  data-bs-toggle="dropdown"
                ></img>
              </div>
            }
          >
            <NavDropdown.Item onClick={handleLogoutClick}>
              Logout
            </NavDropdown.Item>
          </NavDropdown>
        </Nav>
      </Navbar>
    </div>
  );
}

export default Logout;
