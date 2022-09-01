import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
baseApi.enhanceEndpoints({
  addTagTypes: ["coincard"],
});
const coincardapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    coincard: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/coin-cards/`,
        method: "get",
      }),
      providesTags: ["coincard"],
    }),

    getData: build.mutation({
      query: ({ ...data }) => ({
        url: `/v1/coin-cards`,
        method: "get",
        data,
      }),
    }),
  }),
});

export default coincardapi;
export const {
  useCoincardQuery: useCoinCard,

  useGetDataMutation: useData,
} = coincardapi;
