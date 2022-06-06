import { useIsAuthenticated } from 'App/Auth/hooks';
import React from 'react';
import { Route, Routes } from 'react-router-dom';
import Logout from 'Screens/Logout/Logout';
import RecoveryCodeTestStep from 'Screens/SignUp/RecoveryCodeTestStep';
import RecoveryCodeBoxStep from "Screens/SignUp/RecoveryStep/RecoveryStep";


const AuthRoutes = (props) => {
  const isAuthenticated = useIsAuthenticated()
  if(!isAuthenticated){
    return <React.Fragment/>
  }
  return <Routes>
    <Route path="/" element={<Logout />} />
    <Route path="/logout" element={<Logout />} />
    <Route path="/recovery-codes" element={<RecoveryCodeBoxStep />} />
    <Route path="/recovery-test" element={<RecoveryCodeTestStep />} />
  </Routes>
}

export default AuthRoutes;
