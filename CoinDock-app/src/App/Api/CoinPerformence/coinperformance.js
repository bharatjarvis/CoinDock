import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const coinperformanceapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
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
            heading: "Total BTC",
            balance: 0.00115508471,
            coin_id: "BTC",
            coin_name: "Bitcoin",
            img_url:
              '"https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/4caf2b16a0174e26a3482cea69c34cba.png"',
          },
        };
      },
      provideTags: ["total"],
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
            heading: "Primary Currency",
            "coin-name": "INR",
            balance: 79371.2342079689,
          },
        };
      },
      provideTags: ["primarycurrency"],
    }),
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
            heading: "Top Performer ",
            balance: 19975.52151559625,
            coin_name: "Bitcoin",
            coin_id: "BTC",
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
            heading: "Low Performer ",
            balance: 1133.3528207302234,
            coin_name: "Ethereum",
            coin_id: "ETH",
          },
        };
      },
      provideTags: ["lowperformer"],
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
