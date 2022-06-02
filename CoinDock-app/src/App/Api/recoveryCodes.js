import baseApi from "./api";

export const recoveryCodes = baseApi.injectEndpoints({
  endpoints: (build) => ({
    getRecoveryCodes: build.query({
      query: userId => `/v1/users/${userId}/recovery-codes`,
      // transformResponse: (response) => {
      //   return response;
      // },
      providesTags: ["recover-codes"],
    }),

    getRecoveryCodesDownload: build.mutation({
        query: ({userId}) => ({
          url: `/v1/users/${userId}/recovery-codes/download`,
          method: 'get',
          responseType: 'blob',
      }),

      // transformResponse: (response, meta, arg) => {
      //   console.log(response)
      //   return response
      // }      ,

    }),
  }),
});

// export default recoveryCodes
export const { useGetRecoveryCodesQuery, useGetRecoveryCodesDownloadMutation } = recoveryCodes
