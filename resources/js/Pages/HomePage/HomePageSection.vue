<script setup>
let { title, id } = defineProps(['title', 'id'])
</script>
<template>
  <div class="relative">
    <div
      class="absolute top-[-100px] left-0 bg-slate-900 h-10x w-10x z-30"
      :id="id"
    ></div>
    <p class="text-center text-5xl text-deep-purple mb-10">{{ title }}</p>
    <div class="flex gap-10 flex-wrap">
      <slot />
    </div>
  </div>
</template>
