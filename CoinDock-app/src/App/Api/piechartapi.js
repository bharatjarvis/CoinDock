import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const piechartapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    pie: build.query({
      query: (filter) => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        params: { filter },
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          result: {
            Bitcoin: 9,
            Ethereum: 14,
          },
        };
      },
    }),
    piefilter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
      }),
      transformResponse: (response) => {
        return {
          message: "success",
          data: ["coins", "currency"],
        };
      },
      provideTags: ["piechart"],
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

export default piechartapi;
export const {
  usePieQuery: usePieChart,
  usePiefilterQuery: usePieFilter,

  useGetDataMutation: useData,
} = piechartapi;
