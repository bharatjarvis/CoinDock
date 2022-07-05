import { getUserId } from "App/Auth/helper";
import baseApi from "./api";
const accapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    account: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
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
       
       
    //    [
    //     {key:'ProfileSettings', name: 'Profile settings', items: [
    //         {id:1,name: 'Name', key: 'name',value :'Jady Hayes',type: 'edit'},
    //         {id:2,name: 'Gender', key: 'gender',value:'Male'},
    //         {id:3,name: 'Country', key: 'country',value:'UK'}
    //      ]},
         
    //      {key:'AccountSettings', name: 'Account settings', items: [
    //        {id:1,name: 'Email', key: 'email', type: 'edit',value:'will.carrie@example.org'},
    //        {name: 'Change password', key: 'changePassword',type: 'edit1'},
    //        {name: 'Regenerate recovery words', key: 'regenerateRecoveryWords'}
    //     ]},
    //     {key:'SystemSettings', name: 'System settings', items: [
    //      {id:1,name: 'Primary currency', key: 'primaryCurrency'},
    //      {id:2,name: 'Secondary currency', key: 'secondaryCurrency'},
    //   ]},
    //  ],
     provideTags :['account']
      }),
       getData: build.mutation({
        query: ({
          date,...data}) => ({
          url:  "/v1/signup",
          method: "post",
          data: {
            date_of_birth: date,
          },
        }),
      }),
  
}),
});

export default accapi;
export const { useAccountQuery: useAccount, useGetDataMutation: useData } = accapi;

