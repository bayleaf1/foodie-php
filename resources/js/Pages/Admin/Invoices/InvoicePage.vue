<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import endpoints from '../../../api/endpoints.js'
import fetchApp from '../../../api/fetchApp.js'
import AdminLayoutCard from '../../../components/AdminLayoutCard.vue'
import GoBackButton from '../../../components/GoBackButton.vue'
import OrderStatus from '../../../components/OrderStatus.vue'
import { renderPhoneNumber } from '../../../utils/phoneNumber.js'

let defInvoice = {
  id: 1,
  public_id: '0000',
  status: 'created',
  customer_email: '',
  customer_name: '',
  customer_phone: '',
  customer_city: '',
  customer_address: '',
  products: [],
  price: 0,
}
let id = useRoute().params.id

let invoice = ref({ ...defInvoice })
let loading = ref(true)

function fetchInvoice() {
  fetchApp({
    endpoint: endpoints.invoice(id),
    onSuccess: ({ data }) => (
      console.log(data), Object.assign(invoice.value, data.invoice)
    ),
    onFinally: () => {
      loading.value = false
    },
  })
}

onMounted(fetchInvoice)
</script>

<template>
  <go-back-button />

  <admin-layout-card
    classes="mt-2"
    :title="`Invoice #` + id"
    :loading="loading"
  >
    <div class="border rounded-sm lg:w-1/3 min-w-[400px]">
      <v-table density="compact" class="">
        <tbody>
          <tr>
            <td>Id:</td>
            <td>{{ invoice.id }}</td>
          </tr>
          <tr>
            <td>Public id:</td>
            <td>{{ invoice.public_id }}</td>
          </tr>
          <tr>
            <td>Status:</td>
            <td><order-status :status="invoice.status" /></td>
          </tr>
          <tr>
            <td>Name:</td>
            <td>{{ invoice.customer_name }}</td>
          </tr>
          <tr>
            <td>Phone:</td>
            <td>{{ renderPhoneNumber(invoice.customer_phone) }}</td>
          </tr>
          <tr>
            <td>Email:</td>
            <td>{{ invoice.customer_email }}</td>
          </tr>
          <tr>
            <td>City:</td>
            <td>{{ invoice.customer_city }}</td>
          </tr>
          <tr>
            <td>Address:</td>
            <td>{{ invoice.customer_address }}</td>
          </tr>
          <tr>
            <td>Price:</td>
            <td>{{ invoice.price + '$' }}</td>
          </tr>

          <tr v-for="(p, i) in invoice.products" :key="i">
            <td class="whitespace-nowrap">Product #{{ i + 1 }}:</td>
            <td>
              <router-link
                :to="'/admin/dashboard/products/' + p.id"
                class="underline"
                >{{ p.name }}</router-link
              >
              <span class="whitespace-nowrap">
                x{{ p.quantity }} = {{ p.price }}$
              </span>
            </td>
          </tr>
        </tbody>
      </v-table>
    </div>
  </admin-layout-card>
</template>
