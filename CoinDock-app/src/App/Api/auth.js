import baseApi from "./api";
import { store } from "App/Reducers";

const auth = baseApi.injectEndpoints({
  endpoints: (build) => ({
    login: build.mutation({
      query: ({ ...data }) => ({
        url: "/v1/login",
        method: "post",
        data,
      }),
    }),

    logout: build.mutation({
      query: () => ({
        url: "/v1/logout",
        method: "post",
      }),
      transformResponse: (response) => {
        localStorage.clear();
        store.dispatch({
          type: "RESET"
        })
        return response;
      },
    }),

    refresh: build.mutation({
      query: () => ({
        url: "/v1/refresh",
        method: "post",
      }),
    }),
  }),
});

export default auth;
export const {
  useLoginMutation: useLogin,
  useLogoutMutation: useLogout,
  useRefreshMutation: useRefresh,
} = auth;
