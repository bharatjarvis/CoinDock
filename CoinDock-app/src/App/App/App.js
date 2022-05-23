import React from "react";
import { Route, Routes } from "react-router-dom";
import { Provider } from "react-redux";
import { store } from "../Reducers";
import "./App.css";
import Direction from "../Routes/index.js";
import Header from "../../Screens/Logout/Navbar.js";
import { BrowserRouter } from "react-router-dom";
import Login from "../../Screens/Login/Login";

function App() {
  return (
    <Provider store={store}>
      <div className="App">
        <header className="App-header" />
        <Direction />
      </div>
    </Provider>
  );
}

export default App;
