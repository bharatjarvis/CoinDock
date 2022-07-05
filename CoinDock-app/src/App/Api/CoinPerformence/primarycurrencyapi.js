import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const primarycurrencyapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    primary: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => [
        // { key: "totalBtc", value: "₿0.00001", name: "Total Btc" },
        { key: "primaryCurrency", value: "$26.72", name: "Primary Curency" },
        // { key: "topPerformer", value: "BTC", name: "Top Performer" },
        //
        // {
        //     "total-btc": {
        //       "Total BTC": 0.0010934200000000001,
        //     },
        //     "primaryCurrency": {
        //       "CAD": 26996.42,
        //     },
        //     "top-performer": {
        //       "BTC": 21035.5,
        //     },
        //     "low-performer": {
        //       "FLUX": 0.46,
        //     },
        //   },
      ],
      provideTags: ["primary"],
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

export default primarycurrencyapi;
export const { usePrimaryQuery: usePrimary, useGetDataMutation: useData } =
  primarycurrencyapi;
