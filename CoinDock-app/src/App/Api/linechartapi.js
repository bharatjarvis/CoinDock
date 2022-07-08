import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const linechartapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    line: build.query({
      query: (filter) => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        params: { filter },
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          result: {
            coin: "BTC",
            data: [
              {
                "2021-07": 34974.26497547832,
              },
              {
                "2021-08": 44759.215336629866,
              },
              {
                "2021-09": 45627.365352228306,
              },
            ],
          },
        };
      },
      provideTags: ["linechart"],
    }),
    linefilter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          data: ["weekly", "monthly", "yearly"],
        };
      },
      provideTags: ["linefilter"],
    }),
    coinfilter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          data: ["Coins", "Bitcoin", "Ethereum"],
        };
      },
      provideTags: ["coinfilter"],
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

export default linechartapi;
export const {
  useLineQuery: useLineChart,
  useLinefilterQuery: useLineFilter,
  useCoinfilterQuery: useCoinFilter,
  useGetDataMutation: useData,
} = linechartapi;
