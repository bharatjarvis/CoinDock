import { getUserId } from "App/Auth/helper";
import { store } from "App/Reducers";
import baseApi from "./api";
import piechartapi from "./piechartapi";

const wallet = baseApi.injectEndpoints({
  endpoints: (build) => ({
    addWallet: build.mutation({
      query: ({
        wallet,
        walletname,
        walletaddress,

        ...data
      }) => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
        data: {
          wallet: wallet,
          wallet_name: walletname,
          wallet_address: walletaddress,
        },
      }),
      transformResponse: (response) => {
        return response;
      },
    }),
  }),
});

export default wallet;

export const { useAddWalletMutation } = wallet;
export const { usePrefetch: useWalletPrefetch } = wallet;
