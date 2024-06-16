<script setup>
let { onOk, subtitle, title } = defineProps(['onOk', 'subtitle', 'title'])
</script>

<template>
  <v-dialog max-width="500">
    <template v-slot:activator="{ props: activatorProps }">
      <slot :activatorProps="activatorProps"></slot>
    </template>

    <template v-slot:default="{ isActive }">
      <v-card :title="title">
        <v-card-text v-if="subtitle"> </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn text="Dismiss" @click="isActive.value = false"></v-btn>
          <v-btn text="OK" @click="onOk(), (isActive.value = false)"></v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>
