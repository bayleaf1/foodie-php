<script setup>
import AdminLayoutCard from '../../../components/AdminLayoutCard.vue'

let { state, loading, table, headerCells, title, searchableFields } =
  defineProps([
    'state',
    'loading',
    'table',
    'headerCells',
    'title',
    'searchableFields',
  ])

function setSearchableField(v) {
  state.page = 1
  state.searchableField = v
  state.search = ''
}
function setSearch(v) {
  state.page = 1
  state.search = v
}

function setSorting(v) {
  state.sorting = v
}
</script>
<template>
  <admin-layout-card :title="title" :loading="loading">
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
        <v-text-field
          label="filter..."
          :value="state.search"
          class="max-w-[200px] mr-2"
          density="compact"
          variant="underlined"
          @update:modelValue="setSearch"
        ></v-text-field>
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

      <slot name="rightSideOfHeader"></slot>
    </div>

    <v-table density="compact">
      <thead>
        <tr>
          <th v-for="cell in headerCells" class="text-left">{{ cell }}</th>
        </tr>
      </thead>
      <tbody>
        <slot>Please, render rows :)</slot>
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
