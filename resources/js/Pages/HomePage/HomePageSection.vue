<script setup>
let { title } = defineProps(['title'])
</script>
<template>
  <section>
    <p class="text-center text-5xl text-deep-purple mb-10">{{ title }}</p>
    <div class="flex gap-10 flex-wrap">
      <slot />
    </div>
  </section>
</template>
