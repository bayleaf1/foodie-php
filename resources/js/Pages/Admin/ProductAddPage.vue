<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import endpoints from '../../api/endpoints.js'
import fetchApp from '../../api/fetchApp.js'
import AdminInnerTemplate from './parts/AdminInnerTemplate.vue'
import ProductPageForm from './parts/ProductPageForm.vue'
import { ProductPageInitialState } from './parts/ProductPageUtils.js'
import createErrorsStateForForm from '../../utils/createErrorsStateForForm.js'

let state = ref({ ...ProductPageInitialState })
let errors = ref(createErrorsStateForForm(ProductPageInitialState))
let loading = ref(false)

let router = useRouter()
function onCreate() {
  loading.value = true
  fetchApp({
    endpoint: endpoints.products,
    method: 'post',
    body: { ...state.value },
    errorModelFor422: errors,
    onSuccess: ({ data }) => {
      router.replace('/admin/dashboard/products/' + data.product_id)
    },
    onFinally: () => (loading.value = false),
  })
}
</script>

<template>
  <admin-inner-template title="Add new product" :loading="loading">
    <product-page-form
      :state="state"
      :errors="errors"
      :button-enabled="!loading"
      @btn-click="onCreate"
      buttonLabel="Create"
    ></product-page-form>
  </admin-inner-template>
</template>
