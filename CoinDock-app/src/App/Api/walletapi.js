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
      transformResponse: (response) => {
        return response;
      },
    }),
    coins: build.query({
      query: (params) => {
        return {
          url: `/v1/coins/accepted-crypto`,
          params: { ...params },
          method: "get",
        };
      },

      provideTags: ["coins"],
    }),
  }),
});

export default wallet;

export const { useAddWalletMutation, useCoinsQuery: useCoins } = wallet;
export const { usePrefetch: useWalletPrefetch } = wallet;
