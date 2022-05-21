import baseApi from "./api";

const p = baseApi.injectEndpoints({
  endpoints: (build) => {
    return build.query({
      url: "/",
    });
  },
});
