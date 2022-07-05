import { getUserId } from "App/Auth/helper";
import baseApi from "../api";
const lowperformerapi = baseApi.injectEndpoints({
  endpoints: (build) => ({
    low: build.query({
      query: () => ({
        url: `/v1/users/${getUserId()}/recovery-codes`,
        method: "get",
      }),
      transformResponse: (response) => [
        { key: "lowPerformer", value: "ETH", name: "Low Performer" },
      ],
      provideTags: ["lowperformer"],
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

export default lowperformerapi;
export const { useLowQuery: useLowperformer, useGetDataMutation: useData } =
  lowperformerapi;
