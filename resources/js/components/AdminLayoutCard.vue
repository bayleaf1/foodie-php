<script setup>
let p = defineProps(['title', 'classes'])
</script>

<template>
  <v-card :class="`grow ` + p.classes" color="white" :title="p.title">
    <v-card-text>
      <slot />
    </v-card-text>
  </v-card>
</template>
