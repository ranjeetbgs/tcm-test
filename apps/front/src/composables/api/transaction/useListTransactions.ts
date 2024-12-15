import type { Transaction } from "~/types/Transaction";
import { GET } from "~/constants/http";
import useAppFetch from "~/composables/useAppFetch";

export default async function useListTransactions() {
  return useAppFetch<Array<Transaction>>(() => "/transactions", {
    key: "listTransactions",
    method: GET,
    lazy: true,
  });
}
