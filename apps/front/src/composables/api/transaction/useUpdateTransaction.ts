import { PUT } from "~/constants/http";
import type { Transaction, TransactionId } from "~/types/Transaction";
import useBasicError from "~/composables/useBasicError";


export default function useUpdateTransaction() {
  const { $appFetch } = useNuxtApp();
  const { setError, resetError, errorMessage, violations } = useBasicError();
  return {
    errorMessage,
    violations,
    async setLocation(TransactionId: TransactionId, location:any) {
      try {
        resetError();
        const response = await $appFetch<Transaction>("/transactions/" + TransactionId, {
          method: PUT,
          body:location
        });
        if (!response) {
          throw createError("Error while getting location");
        }
        return response;
      } catch (e: any) {
        setError(e);
        throw e;
      }
    },
  };
}
