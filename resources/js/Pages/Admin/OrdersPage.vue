<script setup>
import { ref, watch } from 'vue'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import Clock from '../../utils/Clock'
import endpoints from '../../api/endpoints'
import OrderStatus from '../../components/OrderStatus.vue'
import { useRouter } from 'vue-router'

const headerCells = ['ID', 'Status', 'Price', 'Created At']

let table = {
  totalPages: 20,
  rows: [
    {
      id: 1,
      status: 'canceled',
      price: '2$',
      createdAt: Clock.formatOrderCreation(new Date()),
    },
    {
      id: 1,
      status: 'created',
      price: '2$',
      createdAt: Clock.formatOrderCreation(new Date()),
    },
    {
      id: 1,
      status: 'confirmed',
      price: '2$',
      createdAt: Clock.formatOrderCreation(new Date()),
    },
    {
      id: 1,
      status: 'finished',
      price: '2$',
      createdAt: Clock.formatOrderCreation(new Date()),
    },
  ],
}

const searchableFields = ['Id', 'status', 'price']

let state = ref({
  page: 2,
  searchableField: searchableFields[0],
  search: '',
  sorting: 'desc',
})

function setSearchableField(v) {
  state.value.page = 1
  state.value.searchableField = v
  state.value.search = ''
}
function setSearch(v) {
  state.value.page = 1
  state.value.search = v
}

function setSorting(v) {
  state.value.sorting = v
}

let r = useRouter()
function navigateToOrderPage(id) {
  r.push(`/admin/dashboard/orders/` + id)
}

watch(state.value, (v) => {
  console.log('updates', endpoints.ordersTable({ ...v }))
})
</script>

<template>
  <admin-layout-card title="Orders">
    <div class="flex">
      <v-select
        :value="state.searchableField"
        @update:modelValue="setSearchableField"
        variant="underlined"
        color="deep-blue"
        :items="searchableFields"
        density="compact"
        class="max-w-[80px]"
      ></v-select>
      <!--  -->
      <v-text-field
        label="filter..."
        :value="state.search"
        class="max-w-[200px] mr-2"
        density="compact"
        variant="underlined"
        @update:modelValue="setSearch"
      ></v-text-field>
      <!--  -->
      <!-- v-model="state.sorting" -->
      <v-select
        :value="state.sorting"
        @update:modelValue="setSorting"
        variant="underlined"
        color="deep-blue"
        :items="['asc', 'desc']"
        density="compact"
        class="max-w-[70px]"
      ></v-select>
    </div>

    <v-table density="compact">
      <thead>
        <tr>
          <th v-for="cell in headerCells" class="text-left">{{ cell }}</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="c in table.rows"
          :key="c.id"
          class="hover:bg-slate-100 cursor-pointer"
          @click="navigateToOrderPage(c.id)"
        >
          <td>{{ c.id }}</td>
          <td>
            <order-status :status="c.status"></order-status>
          </td>
          <td>{{ c.price }}</td>
          <td>
            {{ c.createdAt }}
          </td>
        </tr>
      </tbody>
    </v-table>
    <div class="w-fit mt-5">
      <v-pagination
        v-model="state.page"
        :length="table.totalPages"
        :total-visible="6"
        rounded="circle"
      ></v-pagination>
    </div>
  </admin-layout-card>
</template>
