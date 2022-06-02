import baseApi from "./api";

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
        url: "/v1/signup",
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
      transformResponse: (response) => {
        if (response.code !== 200) {
          throw response;
        }

        return response;
      },
    }),
  }),
});

export default signup;

export const { usePostRegisterMutation } = signup;
export const { usePrefetch: useSignupPrefetch } = signup;
