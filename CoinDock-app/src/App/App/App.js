import React from "react";
import { Provider } from "react-redux";
import { store } from "../Reducers";
import "./App.css";
import Routes from "../Routes";

function App() {
  return (
    <Provider store={store}>
      <div className="cd-app-continer">
        <Routes />
      </div>
    </Provider>
  );
}

export default App;
