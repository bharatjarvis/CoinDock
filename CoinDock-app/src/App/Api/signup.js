import baseApi from "./api";

const p = baseApi.injectEndpoints({
  endpoints: (build) => ({
    p: build.query((name) => ({
      url: "/",
    })),
  }),
});

p.usePQuery();
