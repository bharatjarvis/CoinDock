import baseApi from "./api";

const auth = baseApi.injectEndpoints({
    endpoints: (build) => ({
        login: build.mutation({
           query: ({...data}) => ({
               url: '/v1/login',
               method: 'post',
               data,
           }),
        }),
        logout: build.mutation({
            query: ({...data}) => ({
                url: '/v1/logout',
                method: 'post',
                data,
            }),
            transformResponse: (response) => {
                localStorage.clear()
                return response
            }
         }),
         refresh: build.mutation({
            query: ({...data}) => ({
                url: '/v1/refresh',
                method: 'post',
                data,
            })
         })
    })
})

export default auth
export const {useLoginMutation: useLogin, useLogoutMutation: useLogout,useRefreshMutation:useRefresh} = auth
