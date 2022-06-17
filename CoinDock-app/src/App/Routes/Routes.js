import React from "react";
import Header from "App/Header/Header";
import { BrowserRouter } from "react-router-dom";
import AuthRoutes from "./AuthRoutes";
import PublicRoutes from "./PublicRoutes";
import RouteLoader from "./RouteLoader";

const Direction = () => {
  return (
    <BrowserRouter>
      <Header />
      <div style={{ flexGrow: 1 }}>
        <RouteLoader>
          <PublicRoutes />
          <AuthRoutes />
        </RouteLoader>
      </div>
    </BrowserRouter>
  );
};
export default Direction;
