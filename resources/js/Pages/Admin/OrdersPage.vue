<script setup>
import { computed, onMounted, ref } from 'vue'
import endpoints from '../../api/endpoints'
import useAppSwr from '../../api/useAppSwr'
import OrderStatus from '../../components/OrderStatus.vue'
import Clock from '../../utils/Clock'
import AdminTable from './parts/AdminTable.vue'
import { createStateRef, createTableRef } from './parts/AdminTableUtils'

const headerCells = ['ID', 'Status', 'Email', 'Created At']
const searchableFields = ['id', 'status', 'email']

const table = createTableRef({
  rows: [
    // {
    //   id: 1,
    //   status: 'confirmed',
    //   email: 'test@mail.com',
    //   price: 10,
    //   created_at: Date.now(),
    // },
  ],
})

let state = createStateRef({ searchableField: searchableFields[0] })

let loading = ref(false)

const { refresh } = useAppSwr({
  reactiveEndpoint: computed(() => endpoints.ordersTable({ ...state.value })),
  onSuccess: ({ data }) => (table.value = { ...table.value, ...data.table }),
  loadingModel: loading,
})

onMounted(() => {
  Echo.channel('orders')
    .subscribed(function () {
      console.log('subscribed To Channel')
    })
    .listen('.order.created', (e) => {
      console.log('CREATEDDD', e)
      refresh()
    })
})
</script>

<template>
  <admin-table
    title="Orders"
    :state="state"
    :table="table"
    :headerCells="headerCells"
    :loading="loading"
    :searchableFields="searchableFields"
  >
    <tr
      v-for="c in table.rows"
      :key="c.id"
      class="hover:bg-slate-100 cursor-pointer"
      @click="$router.push(`/admin/dashboard/orders/` + c.id)"
    >
      <td>{{ c.id }}</td>
      <td>
        <order-status :status="c.status" />
      </td>
      <td>{{ c.email }}</td>
      <td>{{ Clock.formatOrderCreation(c.created_at) }}</td>
    </tr>
  </admin-table>
</template>
