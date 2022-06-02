import { configureStore } from "@reduxjs/toolkit";
import { baseApi } from "../Api";
import { combineReducers } from 'redux';
import thunk from "redux-thunk";
import { logger } from "redux-logger";

const reducer = combineReducers({
  [baseApi.reducerPath]: baseApi.reducer,
})

const store = configureStore({
  reducer: reducer,
  middleware: [ thunk, baseApi.middleware]
});

export default store;
