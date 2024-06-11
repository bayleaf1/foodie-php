<script setup>
let { status } = defineProps(['status'])
function getStyle() {
  let bg = {
    created: 'bg-red-500',
    confirmed: 'bg-blue',
    finished: 'bg-green',
    canceled: 'bg-slate-300',
  }[status]
  return 'p-2 rounded-2xl text-white w-fit ' + bg
}
</script>

<template>
  <div :class="getStyle()">
    {{ status }}
  </div>
</template>
