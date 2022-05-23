import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseApi = createApi({
  baseQuery: fetchBaseQuery({ baseUrl: process.env.REACT_APP_API_DOMAIN }),
  endpoints: (build) => {
    return {};
  },
});

export default baseApi;
