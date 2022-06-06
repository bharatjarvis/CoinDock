import { configureStore } from "@reduxjs/toolkit";
import { baseApi } from "../Api";
import { combineReducers } from "redux";
import thunk from "redux-thunk";
import { logger } from "redux-logger";
import { setupListeners } from "@reduxjs/toolkit/query";
import auth from "App/Api/auth";
import { authReducer } from "App/Auth/reducers";

const reducer = combineReducers({
  [baseApi.reducerPath]: baseApi.reducer,
  auth: authReducer,
});

const rootReducer = (state, action) => {
  if(action.type === 'RESET'){
    return reducer(undefined, action)
  }
  return reducer(state,action)
}

const store = configureStore({
  initialState: {},
  reducer: rootReducer,
  middleware: (getDefaultMiddleWare) => getDefaultMiddleWare({
    serializableCheck: false
  }).concat([thunk, baseApi.middleware, logger, auth.middleware]),
});

setupListeners(store.dispatch)

export default store;
