<template>
  <h1>Dashboard</h1>
  <button @click="logout">Log out</button>
</template>

<script setup>
import JwtStorage from '../../auth'

function logout() {
  JwtStorage.remove()
  location.reload()
}
</script>
