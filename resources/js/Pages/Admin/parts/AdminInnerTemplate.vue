<script setup>
import AdminLayoutCard from '../../../components/AdminLayoutCard.vue'
import GoBackButton from '../../../components/GoBackButton.vue'

let p = defineProps(['title', 'classes', 'loading'])
</script>
<template>
  <go-back-button />
  <admin-layout-card
    :classes="'mt-2 ' + p.classes"
    :title="p.title"
    :loading="p.loading"
  >
    <slot />
  </admin-layout-card>
</template>
