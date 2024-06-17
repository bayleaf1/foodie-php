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

  <div class="max-w-[1314px] mx-auto flex gap-[20px]">
    <div
      v-for="(p, i) in products"
      :key="i"
      class="border max-w-[300px] rounded-3xl hover:shadow-md transition-all cursor-pointer"
    >
      <router-link :to="'/product/' + p.id">
        <div>
          <v-img
            :src="endpoints.productImage(p.images[0])"
            class="h-10 grow"
            :width="400"
            :height="300"
          />
        </div>
        <div class="p-2 px-6 flex justify-between">
          <p class="">{{ p.name || 'lalala' }}</p>
          <p class="text-red">{{ p.price }}$</p>
        </div>
      </router-link>
    </div>
  </div>
  <pre>{{ JSON.stringify(products, null, 2) }}</pre>
</template>
