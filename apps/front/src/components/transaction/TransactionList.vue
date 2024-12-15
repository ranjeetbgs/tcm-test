<template>
  <div>
    <h2>{{ $t("components.transaction.list.title") }}</h2>
    <div
      v-show="transactionsPending"
      v-t="{ path: 'components.transaction.list.pending' }"
    ></div>
    <div v-show="error">{{ error }}</div>
    <div class="overlay" v-show="isLoading">
      <div class="loader"></div>
    </div>
    <div v-show="showModal">
    <div class="overlay" >
      <div class="modal">
       <table>
        <tr v-for="location in locations">
            <td>{{location.address}}</td><td><NuxtLink class="link-btn" to=""
              @click="selectLocationClick(location)" 
            >Use this location</NuxtLink></td>
        </tr>
       </table>
      </div>
      <div class="close">
        <span @click="showModal = false">&times;</span>
      </div>
    </div>
  </div>

    <table v-if="transactions">
      <thead>
        <tr>
          <th>Date/Time</th>
          <th>Amount</th>
          <th>Payment Label</th>
          <th>Location</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="transaction in transactions" :key="transaction.id">
          <td>{{ transaction.created_at }}</td>
          <td>
            {{ transaction.amount }}
          </td>
          <td>
            {{ transaction.payment_label }}
          </td>
          <td>
            <div  v-if="transaction.location">
            {{ transaction.location }}
            </div>
            <div v-else>
            <NuxtLink class="link-btn"
              @click="getLocationClick(transaction)" to=""
            >
              {{ $t("components.transaction.list.getLocation") }}
            </NuxtLink>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>

.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  background-color: #000000da;
  align-items: center;
  text-align: center;
  min-height: 100vh;
}

.modal {
  text-align: center;
  background-color: white;
  height: 320px;
  width: 60%;
  padding: 60px 0;
}
.close {
    margin: -290px 0 0px -24px;
    cursor: pointer;
    z-index: 9999999999;
    font-size: 24px;
}

.link-btn
{
  cursor: pointer;
  color: var(--blue-700);
}
td, th {
border-bottom: 1px solid;
}

.loader {
  border: 5px solid #f3f3f3;
  border-radius: 50%;
  border-top: 5px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


</style>
  

<script setup lang="ts">
import useListTransactions from "~/composables/api/transaction/useListTransactions";
import useUpdateTransaction from "~/composables/api/transaction/useUpdateTransaction";
import type { Transaction } from "~/types/Transaction";

const showModal = useState('showModal', () => false);
const isLoading = useState('isLoading', () => false);

const currentTransactionId = useState('currentTransactionId', () => "");

const locations = [
  {
    latLong:"48.8666645,2.3159525",
    address:"9 Avenue Dutuit, 75008 Paris 8ème Arrondissement Paris Île-de-France France"
  },
  {
    latLong:"48.8694753,2.3104226",
    address:"4 Rond-Point des Champs Élysées-Marcel Dassault, 75008 Paris 8ème Arrondissement Paris Île-de-France France"
  },
  {
    latLong:"48.8685859,2.2928473",
    address:"2 Rue de Belloy, 75116 Paris 16ème Arrondissement Paris Île-de-France France"
  },
  {
    latLong:"48.864118,2.3442282",
    address:"66 Rue Jean-Jacques Rousseau, 75001 Paris 1er Arrondissement Paris Île-de-France France"
  },
  {
    latLong:"48.8593442,2.3392999",
    address:"154 Voie Georges Pompidou, 75001 Paris 1er Arrondissement Paris Île-de-France France"
  }
    
];

const {
  data: transactions,
  error,
  pending: transactionsPending,
  refresh: transactionsRefresh,
} = await useListTransactions();

const { setLocation, errorMessage: er } = useUpdateTransaction();

const getLocationClick = async (transaction: Transaction) => {
  console.log('getLocationClick');
  showModal.value = true;
  currentTransactionId.value = transaction.id;
};

const selectLocationClick = async (location:any) => {
  showModal.value = false;
  isLoading.value = true;
  try {
    await setLocation(currentTransactionId.value,location);
    transactionsRefresh();
    isLoading.value = false;
  } catch (e) {
    logger.error(e);
    throw e;
  }
};




</script>

<style scoped lang="scss"></style>
