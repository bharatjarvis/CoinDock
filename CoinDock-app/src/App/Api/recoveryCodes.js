import { getUserId } from "App/Auth/helper";
import baseApi from "./api";

export const recoveryCodes = baseApi.injectEndpoints({
  endpoints: (build) => ({
    postRecoveryCodes: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return response;
      },
      providesTags: ["recover-codes"],
    }),

    getRecoveryCodesDownload: build.mutation({
      query: () => ({
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
      query: ({ key_response }) => ({
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
        url: `/v1/users/${getUserId()}/recovery-codes/random`,
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
  usePostRecoveryCodesQuery,
  useGetRandomRecoveryCodesQuery,
  useGetRecoveryCodesDownloadMutation,
} = recoveryCodes;
