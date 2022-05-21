import React from "react";
import { Provider } from "react-redux";
import { store } from "../Reducers";
import "./App.css";
import SignUp from "../../Screens/SignUp/SignUp.js";

function App() {
  return (
    <Provider store={store}>
      <div className="App">
        <header className="App-header">
          <SignUp />
        </header>
      </div>
    </Provider>
  );
}

export default App;
