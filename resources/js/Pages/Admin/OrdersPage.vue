<script setup>
import { computed, ref } from 'vue'
import endpoints from '../../api/endpoints'
import useAppSwr from '../../api/useAppSwr'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import Clock from '../../utils/Clock'
import OrderStatus from '../../components/OrderStatus.vue'
import AdminTable from './parts/AdminTable.vue'
import { createStateRef, createTableRef } from './parts/AdminTableUtils'

const headerCells = ['ID', 'Status', 'Email', 'Price', 'Created At']
const searchableFields = ['id', 'status', 'email', 'price']

const table = createTableRef({
  rows: [
    {
      id: 1,
      status: 'confirmed',
      email: 'test@mail.com',
      price: 10,
      created_at: Date.now(),
    },
  ],
})

let state = createStateRef({ searchableField: searchableFields[0] })

let loading = ref(false)

useAppSwr({
  reactiveEndpoint: computed(() => endpoints.ordersTable({ ...state.value })),
  onSuccess: ({ data }) => (table.value = { ...table.value, ...data.table }),
  loadingModel: loading,
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
      @click="$router.push(`/admin/dashboard/products/` + c.id)"
    >
      <td>{{ c.id }}</td>
      <td>
        <order-status :status="c.status" />
      </td>
      <td>{{ c.email }}</td>
      <td>{{ c.price }}$</td>
      <td>{{ Clock.formatOrderCreation(c.created_at) }}</td>
    </tr>
  </admin-table>
</template>
