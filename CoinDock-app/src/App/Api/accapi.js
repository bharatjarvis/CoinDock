import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const accapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    account: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
       }),
       transformResponse: (response) => ({
        message: "Profile Updated Succesfully",
        result: {
            user: {
                id: 2,
                first_name: "Usha",
                last_name: "Ballanki",
                recovery_attempts: 0,
                type: 0,
                date_of_birth: "2015-06-05",
                country: "Mauritania",
                email: "crunolfsdottir@example.com",
                status: 0,
                created_at: "2022-06-20T06:11:31.000000Z",
                updated_at: "2022-06-22T10:25:20.000000Z",
                deleted_at: null
            }
        }
    }),

     provideTags :['account']
  }),
  currency: build.query({
    query: () => ({
      url: `/v1/users/${getUserId()}/recovery-codes`,
      method: "post",
     }),
     transformResponse: (response) => ({
      message: "success",
      results: [
          {
              coin_name: "BTC",
              logo: " \"https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/4caf2b16a0174e26a3482cea69c34cba.png\"",
              BTC_coin: 0.14843041966604087,
              number_of_coins: 25,
              primary_currency: 43174935.65017325,
              secondary_currency: 256341
          },
          {
              coin_name: "RVN",
              logo: "https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png%22",
              BTC_coin: 0.003275020347329241,
              number_of_coins: 2,
              primary_currency: 3454024.3419326744,
              secondary_currency: 5656
          }
      ]
  }),

   provideTags :['account']
}),
      currencyfilter: build.query({
        query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
        }),
       transformResponse: (response) => {
         return {
          message: "success",
          data: ["Bitcoin","Ethereum" ,"Ethereum Classic",
                 "Ravencoin"," FIRO" ,"FLUX" ,"Ergo", "Callisto Network",
                 "BitcoinZ", "Litecoin"," TON" ,"Dash", "Aeternity", "Expanse",
                 " Vertcoin", "Conflux", "US Dollar", "Indian Rupee", "Canadian Dollar"],
          };
        },
        provideTags: ["account"],
        }),
       getData: build.mutation({
        query: ({
          ...data}) => ({
          url:  "/v1/email",
          method: "post",
          data
        }),
      }),
    }),
  });
export default accapi;
export const {
  useAccountQuery: useAccount,
  useCurrencyQuery: useCurrencyValue,
  useGetDataMutation: useData ,
  useCurrencyfilterQuery: useCurrency
} = accapi;
