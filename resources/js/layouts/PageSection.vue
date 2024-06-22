<script setup>
import cn from '../utils/cn'

let { classes, wrapperClasses, id } = defineProps([
  'classes',
  'wrapperClasses',
  'id',
])
</script>
<template>
  <div :class="cn('max-w-[1280px] mx-auto px-[20px]', classes)">
    <slot />
  </div>
</template>
