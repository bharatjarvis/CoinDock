import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const linechartapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    linechart: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => [
        { key: "topPerformer", value: "BTC" },
        { key: "lowPerformer", value: "ETH" },
      ],
      provideTags: ["linechart"],
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
export const { useCoinQuery: useLineChart, useGetDataMutation: useData } =
  linechartapi;
