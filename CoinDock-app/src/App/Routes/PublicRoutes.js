import { useIsAuthenticated } from 'App/Auth/hooks';
import React from 'react';
import { Route, Routes } from 'react-router-dom';
import Login from 'Screens/Login/Login';


const PublicRoutes = () => {
  const isAuthenticated = useIsAuthenticated()
  if(isAuthenticated){
    return <React.Fragment/>
  }
  return <Routes>
  <Route path="/" element={<Login />} />
  <Route path="/login" element={<Login />} />
</Routes>
}

export default PublicRoutes;
