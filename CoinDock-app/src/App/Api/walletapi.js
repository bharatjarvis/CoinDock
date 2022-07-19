import { getUserId } from "App/Auth/helper";
import { store } from "App/Reducers";
import baseApi from "./api";

const wallet = baseApi.injectEndpoints({
  endpoints: (build) => ({
    addWallet: build.mutation({
      query: ({
        coin,
        walletname,
        wallet_id,

        ...data
      }) => ({
        url: `/v1/users/${getUserId()}/add-wallet`,
        method: "post",
        data: {
          coin: coin,
          name: walletname,
          wallet_id: wallet_id,
        },
      }),
      invalidatesTags: [
        "linechart",
        "filter",
        "coinfilter",
        "coinshortname",
        "pie",
        "piefilter",
        "total",
        "primarycurrency",
        "topperformer",
        "lowperformer",
        "coincard",
      ],
      transformResponse: (response) => {
        return response;
      },
    }),
    coins: build.query({
      query: () => {
        return {
          url: `/v1/coins/accepted-crypto`,

          method: "get",
        };
      },

      providesTags: ["coins"],
    }),
  }),
});

export default wallet;

export const { useAddWalletMutation, useCoinsQuery: useCoins } = wallet;
export const { usePrefetch: useWalletPrefetch } = wallet;
