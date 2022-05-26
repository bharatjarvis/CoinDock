import axios from "axios";
import { createApi } from "@reduxjs/toolkit/query/react";

const localStorageAccessToken = process.env.REACT_APP_ACCESS_TOKEN;
const localStorageRefreshToken = process.env.REACT_APP_REFRESH_TOKEN;

export const axiosInstance = axios.create();

axiosInstance.interceptors.request.use(
  (config) => {
    return {
      ...config,
      ...(config.method !== "get" ? { data: config.data } : {}),
      params: config.params,
    };
  },
  (error) => Promise.reject(error)
);

// Append headers based on localstorage tokens
axiosInstance.interceptors.request.use((config) => {
  const accessToken = localStorage.getItem(localStorageAccessToken);
  const refreshToken = localStorage.getItem(localStorageRefreshToken);

  if (accessToken) {
    config.headers.Authorization = `Bearer ${accessToken}`;
  }
  if (refreshToken) {
    config.headers["Refresh-Token"] = refreshToken;
  }
  return config;
});

axiosInstance.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    console.log(error);
    return Promise.reject(error.response);
  }
);

axiosInstance.interceptors.response.use(
  (response) => {
    const accessToken = response.headers["auth-token"];
    const refreshToken = response.headers["refresh-token"];

    if (accessToken) {
      localStorage.setItem(localStorageAccessToken, accessToken);
    }

    if (refreshToken) {
      localStorage.setItem(localStorageRefreshToken, refreshToken);
    }

    return response;
  },
  (error) => {
    return Promise.reject(error);
  }
);

const axiosBaseQuery =
  ({ baseUrl } = { baseUrl: "" }) =>
  ({ method = "get", url, data = {}, params = {}, responseType = "json" }) =>
    axiosInstance({
      method,
      url: baseUrl + url,
      ...(method !== "get" ? { data } : {}),
      params,
      responseType,
    });

const baseApi = createApi({
  reducerPath: "baseApi",
  baseQuery: axiosBaseQuery({ baseUrl: process.env.REACT_APP_API_DOMAIN }),
  endpoints: (build) => {
    return {};
  },
});

export default baseApi;
