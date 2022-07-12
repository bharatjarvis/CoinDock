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
                country: "India",
                email: "crunolfsdottir@example.com",
                status: 0,
                primary_currency: "INR",
                primary_currency_symbol: "₹",
                secondary_currency: "CAD",
                secondary_currency_symbol:"$",
                created_at: "2022-06-20T06:11:31.000000Z",
                updated_at: "2022-06-22T10:25:20.000000Z",
                deleted_at: null
            }
        }
    }),

     provideTags :['account']
  }),

      currencyfilter: build.query({
        query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "post",
        }),
        transformResponse: (response) => ({
          message: "Success",
          results: {
              coins: [
                  {
                      id: 1,
                      coin_id: "USD",
                      name: "US Dollar",
                      is_crypto: 0,
                      status: 1,
                      img_path: "https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0a4185f21a034a7cb866ba7076d8c73b.png",
                      is_default: 0,
                      created_at: "2022-07-08T08:37:25.000000Z",
                      updated_at: "2022-07-08T08:45:21.000000Z"
                  },
                  {
                      id: 14,
                      coin_id: "CAD",
                      name: "Canadian Dollar",
                      is_crypto: 0,
                      status: 1,
                      img_path: "https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/2ba6caaf33b9496e8a39dd96a1b1bbe1.png",
                      is_default: 0,
                      created_at: "2022-07-08T08:37:25.000000Z",
                      updated_at: "2022-07-08T08:45:21.000000Z"
                  },
                  {
                      id: 1461,
                      coin_id: "INR",
                      name: "Indian Rupee",
                      is_crypto: 0,
                      status: 1,
                      img_path: null,
                      is_default: 0,
                      created_at: "2022-07-08T08:37:40.000000Z",
                      updated_at: "2022-07-08T08:45:18.000000Z"
                  }
              ]
          }
      }
          ),

       provideTags :['account']
    }),
        countryfilter: build.query({
          query: () => ({
          url: `/v1/users/${getUserId()}/recovery-codes`,
          method: "post",
          }),
         transformResponse: (response) => ({
          message: "Success",
          results: {
              countries: [
                  "India",
                  "Canada",
                  "Japan",
                  "Germany",
                  "Pakistan",
                  "Switzerland",
                  "Australia",
                  "United States",
                  "New Zealand",
                  "United Kingdom",
                  "Sweden",
                  "Netherlands",
                  "France",
                  "Denmark",
                  "Norway",
                  "Singapore",
                  "South Korea",
                  "Italy",
                  "China",
                  "Finaland",
                  "Spain",
                  "Belgium",
                  "Austria",
                  "United Arab Emirates",
                  "Ireland",
                  "Russia",
                  "Brazil",
                  "Greece",
                  "Thailand",
                  "Portugal",
                  "Israel",
                  "South Africa",
                  "Mexico",
                  "Qatar",
                  "Egypt",
                  "Turkey",
                  "Saudi Arabia",
                  "Malaysia",
                  "Indonesia",
                  "Morocco",
                  "Costa Rica",
                  "Vietnam",
                  "Argentina",
                  "Poland",
                  "Philippines",
                  "Czechia",
                  "Croatia",
                  "Sri Lanka",
                  "Hungary",
                  "Chile",
                  "Peru"
              ]
          }
      }),
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
  useGetDataMutation: useData ,
  useCountryfilterQuery: useCountry,
  useCurrencyfilterQuery: useCurrency
} = accapi;
