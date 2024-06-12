<script setup>
import getBgColorForOrderStatus from '../utils/getBgColorForOrderStatus.js'
let { status } = defineProps(['status'])
</script>

<template>
  <div
    :class="
      'p-0.5 px-2 rounded-2xl text-white w-fit ' +
      getBgColorForOrderStatus(status)
    "
  >
    {{ status }}
  </div>
</template>
