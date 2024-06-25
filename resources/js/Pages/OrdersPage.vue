<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import endpoints from '../api/endpoints'
import fetchApp from '../api/fetchApp'
import OrderStatus from '../components/OrderStatus.vue'
import Clock from '../utils/Clock'
import OrderList from '../utils/OrderList'

let orders = ref([])
let loading = ref(true)
const idList = OrderList.getIdList()

let sortedOrders = computed(() =>
  orders.value.sort((a, b) => Clock.isGt(b.updated_at, a.updated_at))
)

function fetchOrders() {
  fetchApp({
    endpoint: endpoints.ordersOfGuest,
    method: 'post',
    body: idList,
    onSuccess: ({ data }) => (orders.value = data.orders),
    onFinally: () => (loading.value = false),
  })
}
let interval = null
onMounted(() => {
  // idList.forEach((id) => {
  //   Echo.channel('orders.' + id)
  //     .subscribed(function () {
  //       console.log('subscribed To Channel')
  //     })
  //     .listen('.order.updated', (e) => {
  //       orders.value.forEach((o) => {
  //         if (o.id === e.order.id) {
  //           o.status = e.order.status
  //           o.updated_at = e.order.updated_at
  //         }
  //       })
  //       orders.value = [...orders.value]
  //     })
  //     .listenToAll((e) => {
  //       console.log('EEEE', e)
  //     })
  // })
  fetchOrders()
  interval = setInterval(fetchOrders, 1000)
})
onUnmounted(() => {
  clearInterval(interval)
})
</script>
<template>
  <page-section classes="py-20">
    <p class="text-3xl text-center">My orders</p>

    <circular-loader v-if="loading" />
    <div v-else-if="sortedOrders.length" class="pt-5">
      <div
        v-for="(o, idx) in sortedOrders"
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
