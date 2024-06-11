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
class SystemUser {
  constructor(data) {
    this.d = data
  }
  name() {
    return this.d.name || ''
  }
  email() {
    return this.d.email
  }
  toString() {
    return this.d.toString()
  }
}
let user = ref(new SystemUser({}))
let loading = ref(true)

onMounted(() => {
  fetchApp({
    endpoint: '/api/system-users/profile',
    onSuccess: ({ data }) => {
      // console.log('prodile', data)

      user.value = new SystemUser(JSON.parse(data.profile))
    },
    onFinally: () => (loading.value = false),
  })
})

provide('system-user-provider', {
  systemUser: user,
})
</script>
