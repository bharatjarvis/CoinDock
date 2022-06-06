import { getUserId } from "App/Auth/helper";
import baseApi from "./api";

export const recoveryCodes = baseApi.injectEndpoints({
  endpoints: (build) => ({
    getRecoveryCodes: build.query({
      query: ({ userId }) => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => {
        return response;
      },
      providesTags: ["recover-codes"],
    }),

    getRecoveryCodesDownload: build.mutation({
      query: ({ userId }) => ({
        url: `/v1/users/${getUserId()}/recovery-codes/download`,
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

    putRecoveryCodes: build.mutation({
      query: ({ userId, key_response }) => ({
        url: `/v1/users/${getUserId()}/recovery-codes/activate`,
        method: "put",
        data: { key_response },
      }),
      transformResponse: (response) => {
        return response;
      },
    }),

    getRandomRecoveryCodes: build.query({
      query: () => ({
        url: `/v1/random`,
        method: "get",
      }),
      transformResponse: (response) => {
        return response.data;
      },
    }),
  }),
});

export const {
  usePutRecoveryCodesMutation,
  useGetRecoveryCodesQuery,
  useGetRandomRecoveryCodesQuery,
  useGetRecoveryCodesDownloadMutation,
} = recoveryCodes;
