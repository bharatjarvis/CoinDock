import { useIsAuthenticated } from "App/Auth/hooks";
import React from "react";
import { Route, Routes } from "react-router-dom";
import AddWallet from "Screens/AddWallet/AddWallet";
import Login from "Screens/Login/Login";
import SignUp from "Screens/SignUp/SignUp";
import Loading from "Shared/Loading/Loading";

const PublicRoutes = () => {
  const isAuthenticated = useIsAuthenticated();
  if (isAuthenticated) {
    return <React.Fragment />;
  }
  return (
    <Routes>
      <Route path="/" element={<Login />} />
      <Route path="/login" element={<Login />} />
      <Route path="/signup" element={<SignUp />} />
      <Route path="/loading" element={<Loading />} />
      <Route path="/addwallet" element={<AddWallet/>}/>
    </Routes>
  );
};

export default PublicRoutes;
