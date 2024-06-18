<script setup>
import { onMounted, ref } from 'vue'
import endpoints from '../api/endpoints'
import fetchApp from '../api/fetchApp'
import OrderStatus from '../components/OrderStatus.vue'
import Clock from '../utils/Clock'
import OrderList from '../utils/OrderList'
let orders = ref([])
let loading = ref(true)

onMounted(() => {
  fetchApp({
    endpoint: endpoints.ordersOfGuest,
    method: 'post',
    body: OrderList.getIdList(),
    onSuccess: ({ data }) => {
      orders.value = data.orders.sort((a, b) =>
        Clock.isGt(b.updated_at, a.updated_at)
      )
    },
    onFinally: () => (loading.value = false),
  })
})
</script>
<template>
  <page-section classes="py-20">
    <p class="text-3xl text-center">My orders</p>

    <circular-loader v-if="loading" />
    <div v-else-if="orders.length" class="pt-5">
      <div
        v-for="(o, idx) in orders"
        class="'flex gap-5 border rounded-sm shadow p-2 mt-2 max-w-[400px] mx-auto"
        :key="idx"
      >
        <div class="flex justify-between">
          <p class="text-lg font-medium">Order #{{ o.id }}</p>
          <order-status :status="o.status" />
        </div>
        <div class="ml-5">
          <div v-for="(p, key) in o.products" :key="key" class="flex gap-2">
            <router-link :to="'/product/' + p.id" class="underline">
              {{ p.name }}
            </router-link>
            <p>x{{ p.quantity }}</p>
          </div>
        </div>
        <p class="text-end text-xs">
          Last update: {{ Clock.formatOrderUpdate(o.updated_at) }}
        </p>
      </div>
    </div>
    <p v-else class="text-center mt-5">You do not have any orders</p>
  </page-section>
</template>
