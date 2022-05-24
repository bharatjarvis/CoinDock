import { Route, Routes, BrowserRouter } from "react-router-dom";
import Login from "../../Screens/Login/Login";
import SignUP from "../../Screens/SignUp/SignUp";
import Header from "../../Screens/Logout/Navbar";
import RecoveryCodeBoxStep from "../../Screens/SignUp/RecoveryStep/RecoveryStep";
import RecoveryCodeTestStep from "../../Screens/SignUp/RecoveryCodeTestStep";

const Direction = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
        <Route path="/logout" element={<Header />} />
        <Route path="/signup" element={<SignUP />} />
        <Route path="/recovery-codes" element={<RecoveryCodeBoxStep />} />
        <Route path="/recovery-test" element={<RecoveryCodeTestStep />} />
      </Routes>
    </BrowserRouter>
  );
};
export default Direction;
