<script setup>
import { computed, ref, watch } from 'vue'
import endpoints from '../../../api/endpoints'
import useAppSwr from '../../../api/useAppSwr'
import Clock from '../../../utils/Clock'
import AdminTable from '../parts/AdminTable.vue'
import { createStateRef, createTableRef } from '../parts/AdminTableUtils'
import { renderPhoneNumber } from '../../../utils/phoneNumber'
import OrderStatus from '../../../components/OrderStatus.vue'

const headerCells = [
  'ID',
  'Status',
  'Phone',
  'Email',
  'Name',
  'City',
  'Price',
  'Created At',
]
const searchableFields = [
  'id',
  'status',
  'phone',
  'email',
  'name',
  'city',
  'price',
]

const table = createTableRef()

watch(table, console.log)

let state = createStateRef({ searchableField: searchableFields[0] })

let loading = ref(false)

useAppSwr({
  reactiveEndpoint: computed(() => endpoints.invoicesTable({ ...state.value })),
  method: 'post',
  body: state.value,
  onSuccess: ({ data }) => (
    (table.value = { ...table.value, ...data.table }), console.log('DATA', data)
  ),
  loadingModel: loading,
})
</script>

<template>
  <admin-table
    title="Invoices"
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
      @click="$router.push(`/admin/dashboard/invoices/` + c.id)"
    >
      <td>{{ c.id }}</td>
      <td>
        <order-status :status="c.status" />
      </td>
      <td>
        {{ renderPhoneNumber(c.customer_phone) }}
      </td>
      <td>
        {{ c.customer_email }}
      </td>
      <td>
        {{ c.customer_name }}
      </td>
      <td>
        {{ c.customer_city }}
      </td>
      <td>{{ c.price }}$</td>
      <td>
        {{ Clock.formatSystemUserCreation(c.created_at) }}
      </td>
    </tr>
  </admin-table>
</template>
