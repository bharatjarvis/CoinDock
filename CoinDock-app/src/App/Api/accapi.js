
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
         {key:'ProfileSettings', name: 'Profile settings', items: [
             {id:1,name: 'Name', key: 'name',type:'edit'},
             {id:2,name: 'Gender', key: 'gender'},
             {id:3,name: 'Country', key: 'country'}
          ]},
          {key:'AccountSettings', name: 'Account settings', items: [
            {id:1,name: 'Email', key: 'email', type: 'edit'},
            {id:2,name: 'Change password', key: 'changePassword', type: 'edit'},
            {id:3,name: 'Regenerate recovery words', key: 'regenerateRecoveryWords', type: 'edit'}
         ]},
         {key:'SystemSettings', name: 'System settings', items: [
          {id:1,name: 'Primary currency', key: 'primaryCurrency'},
          {id:2,name: 'Secondary currency', key: 'secondaryCurrency'},
       ]},
      ],
       provideTags :['account']
       }),
}),
});

export default accapi;
export const { useAccountQuery: useAccount } = accapi;

