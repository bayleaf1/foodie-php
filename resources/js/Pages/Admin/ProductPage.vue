<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import endpoints from '../../api/endpoints.js'
import fetchApp from '../../api/fetchApp.js'
import AdminInnerTemplate from './parts/AdminInnerTemplate.vue'
import ProductPageForm from './parts/ProductPageForm.vue'

let route = useRoute()
let productId = route.params.id

let loading = ref(true)
let updatingLoading = ref(false)

const initialState = {
  name: '',
  price: 0,
  quantity: 0,
  description: '',
  images: [],
}
let state = ref({ ...initialState })

onMounted(() => {
  fetchApp({
    endpoint: endpoints.product(productId),
    onSuccess: ({ data }) => Object.assign(state.value, data.data),
    onFinally: () => (loading.value = false),
    // onError: ({ data, status }) => {
    //   console.log('Error', status, data, JSON.stringify(data, null, 2))
    // },
  })
})

let errors = ref({
  ...Object.fromEntries(Object.keys(initialState).map((k) => [k, ''])),
  resetFor(field) {
    this[field] = ''
  },
})

function onUpdate() {
  updatingLoading.value = true
  fetchApp({
    endpoint: endpoints.product(productId),
    method: 'patch',
    body: { ...state.value },
    errorModelFor422: errors,
    onFinally: () => (updatingLoading.value = false),
  })
}
</script>

<template>
  <admin-inner-template
    classes="min-h-[422px]"
    :title="'Product #' + productId"
    :loading="loading || updatingLoading"
  >
    <product-page-form
      v-if="!loading"
      :state="state"
      :errors="errors"
      :button-enabled="!updatingLoading"
      @btn-click="onUpdate"
      buttonLabel="Update"
    ></product-page-form>
  </admin-inner-template>
</template>
