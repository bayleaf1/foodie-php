<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import fetchApp from '../api/fetchApp'
import endpoints from '../api/endpoints'

let router = useRouter()

function login() {
  router.push('/admin/login')
}

let products = ref([])

onMounted(() => {
  fetchApp({
    endpoint: endpoints.productsMenu,
    onSuccess: ({ data }) => {
      Object.assign(products.value, data.products)
    },
  })
})
</script>
<template>
  <button @click="login">Login</button>
  <h1 class="text-red">Home</h1>
  <pre>{{ JSON.stringify(products, null, 2) }}</pre>
</template>
