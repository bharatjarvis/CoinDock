import { configureStore } from "@reduxjs/toolkit";
import { baseApi } from "../Api";
import { combineReducers } from "redux";
import thunk from "redux-thunk";
import { logger } from "redux-logger";
import { setupListeners } from "@reduxjs/toolkit/query";
import auth from "App/Api/auth";
import { authReducer } from "App/Auth/reducers";
import accReducer from "App/Auth/reducers/accReducer";
import { popupReducer } from "Screens/AddWallet/AddWalletSlice";

const reducer = combineReducers({
  [baseApi.reducerPath]: baseApi.reducer,
  auth: authReducer,
  account: accReducer,
  addwallet: popupReducer,
});

const rootReducer = (state, action) => {
  if (action.type === "RESET") {
    return reducer(undefined, action);
  }
  return reducer(state, action);
};

const store = configureStore({
  initialState: {},
  reducer: rootReducer,

  middleware: (getDefaultMiddleWare) =>
    getDefaultMiddleWare({
      serializableCheck: false,
    }).concat([thunk, baseApi.middleware, auth.middleware]),
});

setupListeners(store.dispatch);

export default store;
