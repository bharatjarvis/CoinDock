import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const coinperformanceapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    top: build.query({
      query: () => ({
        // url: `/v1/users/(user)/top-performer
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "Success",
          result: {
            "Top-Performer": {
              coin_id: "BTC",
              name: "bitcoin",
              balance: 19313.15507579971,
            },
          },
        };
      },
      provideTags: ["topperformer"],
    }),
    low: build.query({
      query: () => ({
        // url: `/v1/users/(user)/top-performer
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "Success",
          result: {
            "Low-Performer": {
              coin_id: "ETH",
              name: "ethurem",
              balance: 1048.5282013622293,
            },
          },
        };
      },
      provideTags: ["lowperformer"],
    }),
    primary: build.query({
      query: () => ({
        // url: `/v1/users/(user)/top-performer
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          result: {
            "total-INR": {
              name: "Primary Currency",
              primaryCurrency: 78955.0251972996,
            },
          },
        };
      },
      provideTags: ["primarycurrency"],
    }),
    total: build.query({
      query: () => ({
        // url: `/v1/users/(user)/top-performer
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          result: {
            "total-BTC": {
              name: "Total BTC",
              total: 7.884,
              coin_id: "BTC",
              coin_name: "bitcoin",
              img_url:
                '"https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/4caf2b16a0174e26a3482cea69c34cba.png"',
            },
          },
        };
      },
      provideTags: ["total"],
    }),
    getData: build.mutation({
      query: ({ ...data }) => ({
        url: `/v1/email`,
        method: "post",
        data,
      }),
    }),
  }),
});

export default coinperformanceapi;
export const {
  useTopQuery: useTopperformer,
  usePrimaryQuery: usePrimaryCurrency,
  useLowQuery: useLowperformer,
  useTotalQuery: useTotalCurrency,
  useGetDataMutation: useData,
} = coinperformanceapi;
