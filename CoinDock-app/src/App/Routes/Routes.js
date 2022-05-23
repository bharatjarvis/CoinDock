import { Route, Routes, BrowserRouter } from "react-router-dom";
import Login from "../../Screens/Login/Login";
import SignUP from "../../Screens/SignUp/SignUp";
import Header from "../../Screens/Logout/Navbar.js";

const Direction = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
        <Route path="/logout" element={<Header />} />
        <Route path="/signup" element={<SignUP />} />
      </Routes>
    </BrowserRouter>
  );
};
export default Direction;
