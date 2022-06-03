import baseApi from "./api";

export const recoveryCodes = baseApi.injectEndpoints({
  endpoints: (build) => ({
    getRecoveryCodes: build.query({
      query: ({userId}) => ({
        url: `/v1/users/${userId}/recovery-codes`,
        method: 'get',
      }),
      transformResponse: (response) => {
        return response.results;
      },
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
