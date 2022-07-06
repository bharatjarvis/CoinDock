import baseApi from "./api";

const wallet = baseApi.injectEndpoints({
  endpoints: (build) => ({
    getWallet: build.mutation({
      query: ({
        wallet,
        walletname,
        walletaddress,

        ...data
      }) => ({
        url: "/v1/users",
        method: "get",
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

export const { useGetWalletMutation } = wallet;
export const { usePrefetch: useWalletPrefetch } = wallet;
