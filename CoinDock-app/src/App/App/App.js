import React from "react";
import { Provider } from "react-redux";
import { store } from "../Reducers";
import "./App.css";
import Direction from "../Routes";

function App() {
  return (
    <Provider store={store}>
      <div className="cd-app-continer">
        <Direction />
      </div>
    </Provider>
  );
}

export default App;