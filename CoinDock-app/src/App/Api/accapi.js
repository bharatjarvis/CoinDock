import { getUserId } from "App/Auth/helper";

import baseApi from "./api";
baseApi.enhanceEndpoints({addTagTypes: ['accountDetails']})

const accapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    account: build.query({
      query: () => ({
        url:`/v1/users/${getUserId()}/accounts/profile`,
        method: "put",
       }),
      providesTags: ['accountDetails']
  }),

      currencyfilter: build.query({
        query: () => ({
        url: `/v1/coins/currency-conversions`,
        method: "get",
        }),
       provideTags :['account']
    }),
        countryfilter: build.query({
          query: () => ({
          url: `/v1/countries/`,
          method: "get",
          }),
          provideTags: ["account"],
          }),
       putAccountData: build.mutation({
        query: ({
          ...data}) => ({
          url:`/v1/users/${getUserId()}/accounts/profile`,
          method:"put",
          data
        }),
        invalidatesTags: ['accountDetails']
      }),
    }),
  });
export default accapi;
export const {
  useAccountQuery: useAccount,
  usePutAccountDataMutation: useAccountData ,
  useCountryfilterQuery: useCountry,
  useCurrencyfilterQuery: useCurrency
} = accapi;
