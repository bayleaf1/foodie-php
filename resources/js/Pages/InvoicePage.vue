<script setup>
import { onMounted, ref } from 'vue'
import fetchApp from '../api/fetchApp'
import { useRoute } from 'vue-router'
import Invoice from '../components/Invoice/Invoice.vue'

let router = useRoute()
let invoicePublicId = router.params.publicId

let loading = ref(true)
let invoice = ref(null)

function fetchInvoice() {
  fetchApp({
    endpoint: '/api/invoices/show-for-guest/' + invoicePublicId,
    onSuccess: ({ data }) => {
      console.log(`data:`, data)
      invoice.value = data.invoice
    },
    onFinally: () => (loading.value = false),
  })
}

onMounted(fetchInvoice)
</script>
<template>
  <page-section classes="py-20">
    <p class="text-3xl text-center">Invoice #{{ invoicePublicId }}</p>

    <circular-loader v-if="loading" />
    <div v-else class="max-w-[400px] mx-auto mt-6">
      <div v-if="!invoice" class="text-center">Not found</div>
      <v-card v-else>
        <Invoice
          :invoice="invoice"
          :link-to-product="(id) => '/product/' + id"
        />
      </v-card>
      <div class="w-full flex justify-center mt-10">
        <router-link to="/orders">
          <v-btn color="primary" class="mx-auto">Back to orders</v-btn>
        </router-link>
      </div>
    </div>
  </page-section>
</template>
