import {createApi, fetchBaseQuery} from '@reduxjs/toolkit/query/react'

const baseApi = createApi({
    baseQuery: fetchBaseQuery({baseUrl: '/'}),
})

export default baseApi