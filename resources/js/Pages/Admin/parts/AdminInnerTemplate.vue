<script setup>
import AdminLayoutCard from '../../../components/AdminLayoutCard.vue'
import GoBackButton from '../../../components/GoBackButton.vue'

let p = defineProps(['title'])
</script>
<template>
  <go-back-button />
  <admin-layout-card classes="mt-2" :title="p.title">
    <slot />
  </admin-layout-card>
</template>
