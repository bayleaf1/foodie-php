<script setup>
let { classes, wrapperClasses, id } = defineProps([
  'classes',
  'wrapperClasses',
  'id',
])
</script>
<template>
  <div :class="'max-w-[1280px] mx-auto ' + classes">
    <slot />
  </div>
</template>
