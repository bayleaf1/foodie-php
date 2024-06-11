<script setup>
let p = defineProps(['title'])
</script>

<template>
  <v-card class="grow mt-10" color="white" :title="p.title">
    <v-card-text>
      <slot />
    </v-card-text>
  </v-card>
</template>
