import { Route, Routes, BrowserRouter } from "react-router-dom";
import Login from "../../Screens/Login/Login";
import SignUP from "../../Screens/Signup/SignUp";
import Header from "../../Screens/Logout/Navbar";
import RecoveryCodeBoxStep from "../../Screens/Signup/RecoveryStep/RecoveryStep";

const Direction = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
        <Route path="/logout" element={<Header />} />
        <Route path="/signup" element={<SignUP />} />
        <Route path="/recovery-codes"  element={<RecoveryCodeBoxStep />} />
      </Routes>
    </BrowserRouter>
  );
};
export default Direction;
