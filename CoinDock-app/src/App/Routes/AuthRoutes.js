import { useIsAuthenticated } from "App/Auth/hooks";
import React from "react";
import { Route, Routes } from "react-router-dom";
import Account from "Screens/Account/Account";
import Dashboard from "Screens/Dashboard/Dashboard";
import RecoveryCodeTestStep from "Screens/SignUp/RecoveryCodeTestStep";
import RecoveryCodeBoxStep from "Screens/SignUp/RecoveryStep/RecoveryStep";
import RecoveryCodeBoxStepAccount from "Screens/SignUp/RecoveryStep/RecoveryStepAccount";
import RecoveryCodeTestStepAccount from "Screens/SignUp/RecoveryCodeTestStep/RecoveryCodeTestStepAccount";

import AccountSettings from "Screens/Account/settings/AccountSettings";
import ProfileSettings from "Screens/Account/settings/ProfileSettings";
import SystemSettings from "Screens/Account/settings/SystemSettings";
import ProfileName from "Screens/Account/Profile/ProfileName";
import DateofBirth from "Screens/Account/Profile/DateOfBirth";
import Country from "Screens/Account/Profile/Country";
import Accountemail from "Screens/Account/AccountS.js/Accountemail";
import Accountpassword from "Screens/Account/AccountS.js/Accountpassword";
import Primary from "Screens/Account/System.js/Primary";
import Secondary from "Screens/Account/System.js/Secondary";
const AuthRoutes = (props) => {
  const isAuthenticated = useIsAuthenticated();

  if (!isAuthenticated) {
    return <React.Fragment />;
  }

  return (
    <Routes>
      <Route path="/account" element={<Account />} />
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/recovery-codes" element={<RecoveryCodeBoxStep />} />
      <Route
        path="/recovery-codes-account"
        element={<RecoveryCodeBoxStepAccount />}
      />
      <Route path="/profile-settings" element={<ProfileSettings />} />
      <Route path="/profile-name" element={<ProfileName />} />
      <Route path="/profile-dob" element={<DateofBirth />} />
      <Route path="/profile-country" element={<Country />} />
      <Route path="/account-settings" element={<AccountSettings />} />
      <Route path="/account-email" element={<Accountemail />} />
      <Route path="/account-password" element={<Accountpassword />} />
      <Route path="/system-settings" element={<SystemSettings />} />
      <Route path="/primary" element={<Primary />} />
      <Route path="/secondary" element={<Secondary />} />
      <Route path="/recovery-test" element={<RecoveryCodeTestStep />} />

      <Route
        path="/recovery-test-account"
        element={<RecoveryCodeTestStepAccount />}
      />
    </Routes>
  );
};

export default AuthRoutes;
