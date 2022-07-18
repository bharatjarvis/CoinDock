import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const linechartapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    line: build.query({
      query: (params) => {
        return {
          url: `/v1/users/${getUserId()}/graph`,
          params: { ...params },
          method: "get",
        };
      },

      provideTags: ["linechart"],
    }),
    filter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/graph/filter`,
        method: "get",
      }),

      provideTags: ["filter"],
    }),

    coinfilter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/graph/coins`,
        method: "get",
      }),

      provideTags: ["coinfilter"],
    }),
    coinshortname: build.query({
      query: () => ({
        url: `/v1/coins/coin-shortname`,
        method: "get",
      }),

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
