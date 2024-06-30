<script setup>
import cn from '../../utils/cn'

let { title, id, classes } = defineProps(['title', 'id', 'classes'])
</script>
<template>
  <div :class="cn('relative mt-8', classes)">
    <div
      class="absolute top-[-100px] left-0 bg-slate-900 h-10x w-10x z-30"
      :id="id"
    ></div>
    <p class="text-center text-5xl text-brand mb-10">{{ title }}</p>
    <div class="flex gap-10 flex-wrap">
      <slot />
    </div>
  </div>
</template>
