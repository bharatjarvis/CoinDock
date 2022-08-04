import { createSlice, isAnyOf } from "@reduxjs/toolkit";
import auth from "App/Api/auth";
import { authToken, getUserId } from "../helper";

const reducer = createSlice({
  name: "auth",
  initialState: {
    userId: null,
    token: null,
  },
  reducers: {},
  extraReducers: (build) => {
    build.addMatcher(
      isAnyOf(
        auth.endpoints.login.matchFulfilled,
        auth.endpoints.refresh.matchFulfilled
      ),
      (state, { payload }) => {
        const token = authToken();
        if (token) {
          state.userId = getUserId();
          state.token = authToken();
        }
      }
    );
  },
});

export const { reducer: authReducer } = reducer;
