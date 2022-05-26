import baseApi from "./api";

const signup = baseApi.injectEndpoints({
  endpoints: (build) => ({
    postRegister: build.mutation({
      query: ({ ...data }) => ({
        url: "/v1/signup",
        method: "post",
        data,
      }),
      transformResponse: (response) => {
        return response;
      },
    }),
  }),
});

export default signup;

export const { usePostRegisterMutation } = signup;
export const { usePrefetch: useSignupPrefetch } = signup;
