import baseApi from "./api";
import { getUserId } from "App/Auth/helper";
const signup = baseApi.injectEndpoints({
  endpoints: (build) => ({
    postRegister: build.mutation({
      query: ({
        firstname,
        lastname,
        date,
        email,
        country,
        password,
        reenterpassword,
        ...data
      }) => ({
        url: "/v1/users",
        method: "post",
        data: {
          first_name: firstname,
          last_name: lastname,
          date_of_birth: date,
          email: email,
          country: country,
          password: password,
          re_enter_password: reenterpassword,
        },
      }),
    }),
    signupsteps: build.query({
      query: (params) => {
        return {
          url: `/v1/users/${getUserId()}/signup/info`,

          method: "get",
        };
      },
      providesTags: ["signupsteps"],
    }),
  }),
});

export default signup;

export const { usePostRegisterMutation } = signup;
export const {
  usePrefetch: useSignupPrefetch,
  useSignupstepsQuery: useSignupSteps,
} = signup;
