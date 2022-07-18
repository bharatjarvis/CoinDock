import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const coinperformanceapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    total: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/total-default`,
        method: "get",
      }),

      provideTags: ["total"],
    }),
    primary: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/primary-currency`,
        method: "get",
      }),

      provideTags: ["primarycurrency"],
    }),
    top: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/top-performer`,
        method: "get",
      }),

      provideTags: ["topperformer"],
    }),
    low: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/low-performer`,
        method: "get",
      }),

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
