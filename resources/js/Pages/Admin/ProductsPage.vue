<script setup>
import { computed, ref } from 'vue'
import endpoints from '../../api/endpoints'
import useAppSwr from '../../api/useAppSwr'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import Clock from '../../utils/Clock'

const headerCells = ['ID', 'Image', 'Name', 'Price', 'Quantity', 'Created At']
const searchableFields = ['id', 'name', 'price', 'quantity', 'image']

const table = ref({
  totalRows: 0,
  rows: [],
  pagesCount: 0,
})

let state = ref({
  pageSize: 5,
  page: 1,
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

let loading = ref(false)
useAppSwr({
  reactiveEndpoint: computed(() => endpoints.productsTable({ ...state.value })),
  onSuccess: ({ data }) => (table.value = { ...table.value, ...data.table }),
  loadingModel: loading,
})
</script>

<template>
  <admin-layout-card title="Products" :loading="loading">
    <div>
      <p class="text-rightx text-2xl">Total: {{ table.totalRows }}</p>
    </div>
    <div class="flex justify-between mt-5">
      <div class="flex w-fit grow">
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

      <div>
        <router-link to="/admin/dashboard/products/add">
          <v-btn color="deep-purple">Add new</v-btn>
        </router-link>
      </div>
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
            {{ Clock.formatProductCreation(c.created_at) }}
          </td>
        </tr>
      </tbody>
    </v-table>
    <div class="mt-5 flex justify-between">
      <v-pagination
        v-model="state.page"
        :length="table.pagesCount"
        :total-visible="8"
        rounded="circle"
        density="comfortable"
      ></v-pagination>
      <v-select
        v-model="state.pageSize"
        variant="underlined"
        color="deep-blue"
        :items="[5, 10, 15]"
        label="Per page"
        density="compact"
        class="max-w-[80px]"
      ></v-select>
    </div>
  </admin-layout-card>
</template>
