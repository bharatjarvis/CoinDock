import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const coincardapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    coincard: build.query({
      query: (filter) => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        params: { filter },
        method: "post",
      }),
      transformResponse: (response) => {
        return  {
          message: "success",
          result: {
            logo: {
              RVN: "https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png%22",
            },
            "coin-BTC": {
              RVN: 0.02158215991909854,
            },
            number_of_coins: {
              RVN: 34,
            },
            primary_currency: {
              RVN: 54109550.01278717,
            },
            secondary_currency: {
              RVN: 34343,
            },
          },
        };
      },
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
