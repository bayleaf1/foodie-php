<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import fetchApp from '../../../api/fetchApp.js'
import AdminInnerTemplate from '../parts/AdminInnerTemplate.vue'
import { SystemUserPageInitialState } from './parts/SystemUserPageUtils.js'
import createErrorsStateForForm from '../../../utils/createErrorsStateForForm.js'
import endpoints from '../../../api/endpoints.js'
import SystemUserPageForm from './parts/SystemUserPageForm.vue'

let systemUserId = useRoute().params.id

let state = ref({ ...SystemUserPageInitialState })
let errors = ref(createErrorsStateForForm(SystemUserPageInitialState))

let loading = ref(true)
let updatingLoading = ref(false)

onMounted(() => {
  fetchApp({
    endpoint: endpoints.systemUserProfile(systemUserId),
    onSuccess: ({ data }) => {
      Object.assign(state.value, data.profile)
    },
    onFinally: () => (loading.value = false),
  })
})

function onUpdate() {
  updatingLoading.value = true
  fetchApp({
    endpoint: endpoints.systemUserProfile(systemUserId),
    method: 'patch',
    body: { ...state.value },
    errorModelFor422: errors,
    onSuccess: ({ data }) => {
      Object.assign(state.value, data.profile)
      state.value.password = ''
    },
    onFinally: () => (updatingLoading.value = false),
  })
}
</script>

<template>
  <admin-inner-template
    classes="min-h-[422px]"
    :title="'System user #' + systemUserId"
    :loading="loading || updatingLoading"
  >
    <system-user-page-form
      :state="state"
      :errors="errors"
      :button-enabled="!loading"
      @btn-click="onUpdate"
      buttonLabel="Update"
    ></system-user-page-form>
  </admin-inner-template>
</template>
