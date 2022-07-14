import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const linechartapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    line: build.query({
      query: (params) => {
        return {
          url: `/v1/users/${getUserId()}/recovery-codes`,
          params: { ...params },
          method: "post",
        };
      },
      transformResponse: (response) => {
        return {
          message: "success",
          results: {
            BTC: {
              "2022-07-13T09:00:00.0000000Z": 19842.20395433144,
              "2022-07-13T10:00:00.0000000Z": 19792.36728348283,
            },
            RVN: {
              "2022-07-13T09:00:00.0000000Z": 0.021657301991622437,
              "2022-07-13T10:00:00.0000000Z": 0.021575070261595903,
            },
          },
        };
      },
      provideTags: ["linechart"],
    }),
    filter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          results: {
            Day: {
              value: 0,
              key: "Day",
              description: "Day",
            },
            Weekly: {
              value: 1,
              key: "Weekly",
              description: "Weekly",
            },
            Monthly: {
              value: 2,
              key: "Monthly",
              description: "Monthly",
            },
            Yearly: {
              value: 3,
              key: "Yearly",
              description: "Yearly",
            },
          },
        };
      },
      provideTags: ["filter"],
    }),

    coinfilter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          results: ["Coins", "Bitcoin", "Ravencoin"],
        };
      },
      provideTags: ["coinfilter"],
    }),
    coinshortname: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return [
          {
            coin_name: "US Dollor",
            coin_short_name: "USD",
          },
          {
            coin_name: "Bitcoin",
            coin_short_name: "BTC",
          },
        ];
      },
      provideTags: ["coinshortname"],
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
  useFilterQuery: useLineFilter,
  useCoinshortnameQuery: useCoinShortName,
  useCoinfilterQuery: useCoinFilter,
  useGetDataMutation: useData,
} = linechartapi;
