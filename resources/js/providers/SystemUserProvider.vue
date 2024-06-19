<template>
  <v-progress-linear
    v-if="loading"
    indeterminate
    :height="5"
  ></v-progress-linear>
  <slot v-else />
</template>

<script setup>
import { onMounted, ref, provide } from 'vue'
import fetchApp from '../api/fetchApp'
import { SystemUser, SystemUserNull } from '../utils/SystemUser'
import endpoints from '../api/endpoints'
let user = ref(new SystemUserNull())
let loading = ref(true)

onMounted(() => {
  fetchApp({
    endpoint: endpoints.systemUserMe,
    onSuccess: ({ data }) => {
      let sUser = new SystemUser(data.profile)
      sUser.saveToLocalStorage()
      user.value = sUser
    },
    onFinally: () => (loading.value = false),
  })
})

provide('system-user-provider', {
  systemUser: user,
})
</script>
