import baseApi from "./api";

export const recoveryCodes = baseApi.injectEndpoints({
  endpoints: (build) => ({
    getRecoveryCodes: build.query({
      query: ({ userId }) => ({
        url: `/v1/users/${userId}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => {
        return response;
      },
      providesTags: ["recover-codes"],
    }),

    getRecoveryCodesDownload: build.mutation({
      query: ({ userId }) => ({
        url: `/v1/users/${userId}/recovery-codes/download`,
        method: "get",
        responseType: "blob",
      }),
      transformResponse: (response) => {
        const { data } = response;
        const url = window.URL.createObjectURL(data);
        const link = document.createElement("a");
        link.href = url;
        window.open(url);
        link.setAttribute(
          "download",
          response.headers["content-disposition"]
            .split("filename=")[1]
            .replaceAll('"', "")
        );
        document.body.appendChild(link);
        link.click();
        return data;
      },
    }),

    putRecoveryCodes: build.query({
      query: ({ userId }) => ({
        url: `/v1/users/${userId}/recovery-codes/activate`,
        method: "put",
      }),
      transformResponse: (response) => {
        return response;
      },
    }),
  }),
});

export const {
  usePutRecoveryCodesMutation,
  useGetRecoveryCodesQuery,
  useGetRecoveryCodesDownloadMutation,
} = recoveryCodes;
