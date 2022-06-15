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

// const publicRoutes = [
//   { path: "/", element: Login },
//   { path: "/signup", element: SignUP },
// ];

// const privateRoutes = [
//   {
//     path: "/logout",
//     element: Logout,
//     path: "/recovery-codes",
//     element: RecoveryCodeBoxStep,
//     path: "/recovery-test",
//     element: RecoveryCodeTestStep,
//   },
// ];

// const useAuthChecker = () => {
//   const [isAuth, setIsAuth] = useState({});
// };
export default Direction;
