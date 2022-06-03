import { useState } from "react";
import { Route, Routes, BrowserRouter } from "react-router-dom";
import Login from "../../Screens/Login/Login";
import SignUP from "../../Screens/SignUp/SignUp";
import Logout from "../../Screens/Logout/Logout";
import RecoveryCodeBoxStep from "../../Screens/SignUp/RecoveryStep/RecoveryStep";
import RecoveryCodeTestStep from "../../Screens/SignUp/RecoveryCodeTestStep";
import Section from "../../Shared/Section2/Section";
import Header from "../Header/Header";
import Auth from "../Auth/Auth";

const Direction = () => {
  return (
    <BrowserRouter>
      <Header />
      <div style={{ flexGrow: 1,  }}>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<SignUP />} />
          <Route element={<Auth />}>
            <Route path="/logout" element={<Logout />} />
            <Route path="/recovery-codes" element={<RecoveryCodeBoxStep />} />
            <Route path="/recovery-test" element={<RecoveryCodeTestStep />} />
          </Route>
        </Routes>
      </div>
    </BrowserRouter>
  );
};

const publicRoutes = [
  { path: "/", element: Login },
  { path: "/signup", element: SignUP },
];

const privateRoutes = [
  {
    path: "/logout",
    element: Logout,
    path: "/recovery-codes",
    element: RecoveryCodeBoxStep,
    path: "//recovery-test",
    element: RecoveryCodeTestStep,
  },
];

const useAuthChecker = () => {
  const [isAuth, setIsAuth] = useState({});
};
export default Direction;
