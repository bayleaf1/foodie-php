<script setup>
let { classes } = defineProps(['classes'])
</script>
<template>
  <div :class="'max-w-[1280px] mx-auto ' + classes"><slot /></div>
</template>
