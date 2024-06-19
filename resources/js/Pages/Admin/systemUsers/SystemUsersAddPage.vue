<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import endpoints from '../../../api/endpoints.js'
import fetchApp from '../../../api/fetchApp.js'
import AdminInnerTemplate from '../parts/AdminInnerTemplate.vue'
import { SystemUserPageInitialState } from './parts/SystemUserPageUtils.js'
import createErrorsStateForForm from '../../../utils/createErrorsStateForForm.js'
import SystemUserPageForm from './parts/SystemUserPageForm.vue'

let state = ref({ ...SystemUserPageInitialState })
let errors = ref(createErrorsStateForForm(SystemUserPageInitialState))
let loading = ref(false)

let router = useRouter()
function onCreate() {
  loading.value = true
  fetchApp({
    endpoint: endpoints.systemUserRegistration,
    method: 'post',
    body: { ...state.value, c_password: state.value.password },
    errorModelFor422: errors,
    onSuccess: ({ data }) => {
      router.replace('/admin/dashboard/system-users/' + data.system_user_id)
    },
    onFinally: () => (loading.value = false),
  })
}
</script>

<template>
  <admin-inner-template title="Add new system user" :loading="loading">
    <system-user-page-form
      :state="state"
      :errors="errors"
      :button-enabled="!loading"
      @btn-click="onCreate"
      buttonLabel="Create"
    ></system-user-page-form>
  </admin-inner-template>
</template>
