import { configureStore } from "@reduxjs/toolkit";
import { baseApi } from "../Api";
import { combineReducers } from "redux";
import thunk from "redux-thunk";
import { logger } from "redux-logger";
import auth from "../Api/auth";

const reducer = combineReducers({
  [baseApi.reducerPath]: baseApi.reducer,
  auth: auth.reducer,
});

const store = configureStore({
  reducer: reducer,
  middleware: [thunk, baseApi.middleware, logger],
});

export default store;
