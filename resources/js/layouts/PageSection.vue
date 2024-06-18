<script setup>
let { classes, wrapperClasses } = defineProps(['classes', 'wrapperClasses'])
</script>
<template>
  <div :class="'max-w-[1280px] mx-auto ' + classes"><slot /></div>
</template>
