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
            {id:1,name: 'Name', key: 'name',value :'Jadyn Hayes'},
            {id:2,name: 'Gender', key: 'gender',value:'Male'},
            {id:3,name: 'Country', key: 'country',value:'UK'}
         ]},
         {key:'AccountSettings', name: 'Account settings', items: [
           {id:1,name: 'Email', key: 'email', type: 'edit',value:'will.carrie@example.org'},
           {name: 'Change password', key: 'changePassword', type: 'edit'},
           {name: 'Regenerate recovery words', key: 'regenerateRecoveryWords'}
        ]},
        {key:'SystemSettings', name: 'System settings', items: [
         {id:1,name: 'Primary currency', key: 'primaryCurrency'},
         {id:2,name: 'Secondary currency', key: 'secondaryCurrency'},
      ]},
     ],
     provideTags :['account']
      }),
       getData: build.mutation({
        query: ({...data}) => ({
          url: `/v1/email`,
          method: "post",
          data,
        }),
      }),
  
}),
});

export default accapi;
export const { useAccountQuery: useAccount, useGetDataMutation: useData } = accapi;

