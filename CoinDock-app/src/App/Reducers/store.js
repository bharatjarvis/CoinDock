import { configureStore } from "@reduxjs/toolkit";
import { baseApi } from "../Api";

const store = configureStore({
  reducer: {
    [baseApi.reducerPath]: baseApi.reducer,
  },
});

export default store;
