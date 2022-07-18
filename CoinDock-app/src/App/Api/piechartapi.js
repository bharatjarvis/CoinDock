import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const piechartapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    pie: build.query({
      query: (filter_by) => ({
        url: `/v1/users/${getUserId()}/pie-chart/`,
        params: { filter_by },
        method: "get",
      }),
    }),
    piefilter: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/pie-chart/filter`,
        method: "get",
      }),

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
