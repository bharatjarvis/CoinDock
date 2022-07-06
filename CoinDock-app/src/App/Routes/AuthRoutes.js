import { useIsAuthenticated } from "App/Auth/hooks";
import React from "react";
import { Route, Routes } from "react-router-dom";
import Account from "Screens/Account/Account"
import Dashboard from "Screens/Dashboard/Dashboard";
import RecoveryCodeTestStep from "Screens/SignUp/RecoveryCodeTestStep";
import RecoveryCodeBoxStep from "Screens/SignUp/RecoveryStep/RecoveryStep";
import RecoveryCodeBoxStepAccount from "Screens/SignUp/RecoveryStep/RecoveryStepAccount";
import RecoveryCodeTestStepAccount from "Screens/SignUp/RecoveryCodeTestStep/RecoveryCodeTestStepAccount";
import SignUp from "Screens/SignUp";
import Login from "Screens/Login/Login";
const AuthRoutes = (props) => {
  const isAuthenticated = useIsAuthenticated();
  if (!isAuthenticated) {
    return <React.Fragment />;
  }
  return (
    <Routes>
      <Route path="/" element={<Login/>} />
      <Route path="/account" element={<Account/>}/>
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/recovery-codes" element={<RecoveryCodeBoxStep />} />
      <Route path="/recovery-codes-account" element={<RecoveryCodeBoxStepAccount />} />
      <Route path="/recovery-test" element={<RecoveryCodeTestStep />} />
      <Route path="/recovery-test-account" element={<RecoveryCodeTestStepAccount />} />
    </Routes>
  );
};

export default AuthRoutes;
