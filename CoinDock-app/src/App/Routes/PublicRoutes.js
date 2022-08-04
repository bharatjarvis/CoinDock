import { useIsAuthenticated } from "App/Auth/hooks";
import React from "react";
import { Route, Routes } from "react-router-dom";

import Login from "Screens/Login/Login";
import SignUp from "Screens/SignUp/SignUp";

const PublicRoutes = () => {
  const isAuthenticated = useIsAuthenticated();
  if (isAuthenticated) {
    return <React.Fragment />;
  }
  return (
    <Routes>
      <Route path="/" element={<Login />} />

      <Route path="/signup" element={<SignUp />} />
      <Route path="*" element={<Login />} />
    </Routes>
  );
};

export default PublicRoutes;
