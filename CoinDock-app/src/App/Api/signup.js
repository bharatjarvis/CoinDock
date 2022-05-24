import baseApi from "./api";

const signup = baseApi.injectEndpoints({
  endpoints: (build) => ({
    getRegister: build.query({
      query: () => ({
        url: "/v1/register",
        method: "get",
      }),
      transformResponse: (response) => {
        return response;
      },
      providesTags: ["register"],
    }),
  }),
});

export default signup;
export const { useGetRegisterQuery } = signup;
export const { usePrefetch: useSignupPrefetch } = signup;
