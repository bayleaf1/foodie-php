<script setup>
import { computed, ref } from 'vue'
import endpoints from '../../../api/endpoints'
import useAppSwr from '../../../api/useAppSwr'
import Clock from '../../../utils/Clock'
import AdminTable from '../parts/AdminTable.vue'
import { createStateRef, createTableRef } from '../parts/AdminTableUtils'

const headerCells = ['ID', 'Email', 'Role', 'Name', 'Created At']
const searchableFields = ['id', 'email', 'role', 'name']

const table = createTableRef()

let state = createStateRef({ searchableField: searchableFields[0] })

let loading = ref(false)

useAppSwr({
  reactiveEndpoint: computed(() =>
    endpoints.systemUsersTable({ ...state.value })
  ),
  onSuccess: ({ data }) => (
    (table.value = { ...table.value, ...data.table }), console.log('DATA', data)
  ),
  loadingModel: loading,
})
</script>

<template>
  <admin-table
    title="System users"
    :state="state"
    :table="table"
    :headerCells="headerCells"
    :loading="loading"
    :searchableFields="searchableFields"
  >
    <template v-slot:rightSideOfHeader>
      <router-link to="/admin/dashboard/system-users/add">
        <v-btn color="primary">Add new</v-btn>
      </router-link>
    </template>

    <tr
      v-for="c in table.rows"
      :key="c.id"
      class="hover:bg-slate-100 cursor-pointer"
      @click="$router.push(`/admin/dashboard/system-users/` + c.id)"
    >
      <td>{{ c.id }}</td>
      <td>
        {{ c.email }}
      </td>
      <td>{{ c.role }}</td>
      <td>
        {{ c.name }}
      </td>
      <td>
        {{ Clock.formatSystemUserCreation(c.created_at) }}
      </td>
    </tr>
  </admin-table>
</template>
