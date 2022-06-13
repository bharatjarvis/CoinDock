
import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const accapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    account: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
       
      }),
      transformResponse: (response) => [
         {title:'Profile settings' ,content:'welcome'},
         {title:'Account settings',content:'welcome'},
         {title:'System settings' ,content:'welcome'}
      ],
       provideTags :['account']
       }),
}),
});

export default accapi;
export const { useAccountQuery: useAccount } = accapi;

