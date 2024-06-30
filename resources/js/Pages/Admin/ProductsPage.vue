<script setup>
import { computed, ref } from 'vue'
import endpoints from '../../api/endpoints'
import useAppSwr from '../../api/useAppSwr'
import Clock from '../../utils/Clock'
import AdminTable from './parts/AdminTable.vue'
import { createStateRef, createTableRef } from './parts/AdminTableUtils'

const headerCells = [
  'ID',
  'Image',
  'Name',
  'Price',
  'Quantity',
  'Category',
  'State',
  'Created At',
]
const searchableFields = [
  'id',
  'name',
  'price',
  'quantity',
  'category',
  'state',
  'image',
]

const table = createTableRef()

let state = createStateRef({ searchableField: searchableFields[0] })

let loading = ref(false)

useAppSwr({
  reactiveEndpoint: computed(() => endpoints.productsTable({ ...state.value })),
  onSuccess: ({ data }) => (table.value = { ...table.value, ...data.table }),
  loadingModel: loading,
})
</script>

<template>
  <admin-table
    title="Products"
    :state="state"
    :table="table"
    :headerCells="headerCells"
    :loading="loading"
    :searchableFields="searchableFields"
  >
    <template v-slot:rightSideOfHeader>
      <router-link to="/admin/dashboard/products/add">
        <v-btn color="primary">Add new</v-btn>
      </router-link>
    </template>

    <tr
      v-for="c in table.rows"
      :key="c.id"
      class="hover:bg-slate-100 cursor-pointer"
      @click="$router.push(`/admin/dashboard/products/` + c.id)"
    >
      <td>{{ c.id }}</td>
      <td>
        <v-img
          :src="endpoints.productImage(c.images[0])"
          :height="39"
          :width="39"
          aspect-ratio="16/9"
        />
      </td>
      <td>
        {{ c.name }}
      </td>
      <td>{{ c.price }}$</td>
      <td>
        {{ c.quantity }}
      </td>
      <td>
        {{ c.category }}
      </td>
      <td>
        {{ c.state }}
      </td>
      <td>
        {{ Clock.formatProductCreation(c.created_at) }}
      </td>
    </tr>
  </admin-table>
</template>
