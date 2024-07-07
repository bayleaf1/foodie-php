<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import endpoints from '../../../api/endpoints.js'
import fetchApp from '../../../api/fetchApp.js'
import AdminLayoutCard from '../../../components/AdminLayoutCard.vue'
import GoBackButton from '../../../components/GoBackButton.vue'
import Invoice from '../../../components/Invoice/Invoice.vue'
import { defInvoice } from '../../../components/Invoice/invoiceUtils.js'

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
      <Invoice
        :invoice="invoice"
        :link-to-product="(id) => '/admin/invoices/' + id"
      >
        <template #header>
          <tr>
            <td>Id:</td>
            <td>{{ invoice.id }}</td>
          </tr>
          <tr>
            <td>Public id:</td>
            <td>{{ invoice.public_id }}</td>
          </tr>
        </template>
      </Invoice>
    </div>
  </admin-layout-card>
</template>
