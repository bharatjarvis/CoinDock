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
        "message": "Profile Updated Succesfully",
        "result": {
            "user": {
                "id": 2,
                "first_name": "Usha",
                "last_name": "Ballanki",
                "recovery_attempts": 0,
                "type": 0,
                "date_of_birth": "2015-06-05",
                "country": "Mauritania",
                "email": "crunolfsdottir@example.com",
                "status": 0,
                "created_at": "2022-06-20T06:11:31.000000Z",
                "updated_at": "2022-06-22T10:25:20.000000Z",
                "deleted_at": null
            }
        }
    }),
     provideTags :['account']
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
export const { useAccountQuery: useAccount, useGetDataMutation: useData } = accapi;
