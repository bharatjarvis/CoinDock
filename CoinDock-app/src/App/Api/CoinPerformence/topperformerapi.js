import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const topperformerapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    top: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => [
        { key: "topPerformer", value: "BTC", name: "Top Performer" },
      ],
      provideTags: ["topperformer"],
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

export default topperformerapi;
export const { useTopQuery: useTopperformer, useGetDataMutation: useData } =
  topperformerapi;
