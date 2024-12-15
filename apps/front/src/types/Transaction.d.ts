export type TransactionId = string;
export interface Transaction {
  id: TransactionId;
  payment_label: string;
  amount:string,
  location:string,
  created_at:string
}
