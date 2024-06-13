<script setup>
let p = defineProps(['title', 'classes', 'loading'])
</script>

<template>
  <v-card
    :class="`grow ` + p.classes"
    color="white"
    :title="p.title"
    :loading="p.loading"
  >
    <v-card-text>
      <slot />
    </v-card-text>
  </v-card>
</template>
