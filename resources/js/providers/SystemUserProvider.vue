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
let user = ref(new SystemUserNull())
let loading = ref(true)

onMounted(() => {
  fetchApp({
    endpoint: '/api/system-users/profile',
    onSuccess: ({ data }) => {
      // console.log('prodile', data)
      let sUser = new SystemUser(JSON.parse(data.profile))
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
