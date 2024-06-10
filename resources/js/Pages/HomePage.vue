<script setup></script>
<template>
  <h1 class="text-red">Home</h1>
  <button @click="login">Login</button>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router'
let router = useRouter()

function login() {
  router.push('/admin/login')
}
</script>
