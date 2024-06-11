<template>
  <h1>Layout - Dashboard</h1>
  <button @click="logout">Log out</button>
  <slot />
</template>

<script setup>
import JwtStorage from '../auth'

function logout() {
  JwtStorage.remove()
  location.reload()
}
</script>
