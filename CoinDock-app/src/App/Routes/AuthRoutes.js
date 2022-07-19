import { useIsAuthenticated } from "App/Auth/hooks";
import React from "react";
import { Route, Routes } from "react-router-dom";
import Account from "Screens/Account/Account";
import Dashboard from "Screens/Dashboard/Dashboard";
import RecoveryCodeTestStep from "Screens/SignUp/RecoveryCodeTestStep";
import RecoveryCodeBoxStep from "Screens/SignUp/RecoveryStep/RecoveryStep";
import RecoveryCodeBoxStepAccount from "Screens/SignUp/RecoveryStep/RecoveryStepAccount";
import RecoveryCodeTestStepAccount from "Screens/SignUp/RecoveryCodeTestStep/RecoveryCodeTestStepAccount";
import SignUp from "Screens/SignUp";
import Login from "Screens/Login/Login";
import AccountSettings from "Screens/Account/settings/AccountSettings";
import ProfileSettings from "Screens/Account/settings/ProfileSettings";
import SystemSettings from "Screens/Account/settings/SystemSettings";
import ProfileName from "Screens/Account/Profile/ProfileName";
import DateofBirth from "Screens/Account/Profile/DateOfBirth";
import Country from "Screens/Account/Profile/Country";
import Aemail from "Screens/Account/AccountS.js/Aemail";
import Apassword from "Screens/Account/AccountS.js/Apassword";
import Primary from "Screens/Account/System.js/Primary";
import Secondary from "Screens/Account/System.js/Secondary";
const AuthRoutes = (props) => {
  const isAuthenticated = useIsAuthenticated();
  if (!isAuthenticated) {
    return <React.Fragment />;
  }
  return (
    <Routes>
      <Route path="/" element={<Dashboard />} />
      <Route path="/account" element={<Account />} />
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/recovery-codes" element={<RecoveryCodeBoxStep />} />
      <Route
        path="/recovery-codes-account"
        element={<RecoveryCodeBoxStepAccount />}
      />
      <Route path="/profile-settings" element={<ProfileSettings/>}/>
      <Route path="/profile-name" element={<ProfileName/>}/>
      <Route path="/profile-dob" element={<DateofBirth/>}/>
      <Route path="/profile-country" element={<Country/>}/>
      <Route path="/account-settings" element={<AccountSettings/>}/>
      <Route path="/aemail" element={<Aemail/>}/>
      <Route path="/apassword" element={<Apassword/>}/>
      <Route path="/system-settings" element={<SystemSettings/>}/>
      <Route path="/primary" element={<Primary/>}/>
      <Route path="/secondary" element={<Secondary/>}/>
      <Route path="/recovery-test" element={<RecoveryCodeTestStep />} />
      <Route
        path="/recovery-test-account"
        element={<RecoveryCodeTestStepAccount/>}
      />
    </Routes>
  );
};

export default AuthRoutes;
