import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const totalbtcapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    totalbtc: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => [
        { key: "totalBtc", value: "₿0.00001", name: "Total Btc" },
        // { key: "primaryCurrency", value: "$26.72", name: "Primary Curency" },
        // { key: "topPerformer", value: "BTC", name: "Top Performer" },
        // { key: "lowPerformer", value: "ETH", name: "Low Performer" },
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
      provideTags: ["totalbtc"],
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

export default totalbtcapi;
export const { useTotalbtcQuery: useTotalbtc, useGetDataMutation: useData } =
  totalbtcapi;
