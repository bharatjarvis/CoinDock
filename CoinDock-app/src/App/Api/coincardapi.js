import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const coincardapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    coincard: build.query({
      query: () => ({
        // url: `/v1/users/${getUserId()}/recovery-codes`,
        url: `/v1/users/${getUserId()}/coin-cards/`,
        method: "get",
      }),
      // transformResponse: (response) => {
      //   return {
      //     message: "success",
      //     results: [
      //       {
      //         coin_name: "BTC",
      //         logo: "https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/4caf2b16a0174e26a3482cea69c34cba.png",
      //         BTC_coin: 0.2030081012544335,
      //         number_of_coins: 25,
      //         primary_currency: 42541334.03996144,
      //         secondary_currency: 345454,
      //       },
      //       {
      //         coin_name: "RVN",
      //         logo: "https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0a4185f21a034a7cb866ba7076d8c73b.png",
      //         BTC_coin: 0.00020156378650572031,
      //         number_of_coins: 5,
      //         primary_currency: 8508472.825059421,
      //         secondary_currency: 343,
      //       },
      //     ],
      //   };
      // },
      provideTags: ["coincard"],
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

export default coincardapi;
export const {
  useCoincardQuery: useCoinCard,

  useGetDataMutation: useData,
} = coincardapi;
