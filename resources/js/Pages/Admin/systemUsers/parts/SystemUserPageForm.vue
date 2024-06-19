<script setup>
let { state, errors, buttonLabel } = defineProps([
  'state',
  'errors',
  'buttonLabel',
  'buttonEnabled',
])
</script>
<template>
  <div class="grow max-w-[400px] flex flex-col gap-2">
    <v-text-field
      label="Name"
      density="compact"
      v-model="state.name"
      :error-messages="errors.name"
      @input="errors.resetFor('name')"
    />
    <v-text-field
      label="Email"
      density="compact"
      v-model="state.email"
      :error-messages="errors.email"
      @input="errors.resetFor('email')"
    />
    <v-select
      label="Role"
      v-model="state.role"
      @update:modelValue="errors.resetFor('role')"
      :items="[
        {
          title: 'root',
          props: { subtitle: 'Has full access to system' },
        },
        {
          title: 'manager',
          props: { subtitle: 'Has access to orders and products' },
        },
      ]"
      :error-messages="errors.role"
    ></v-select>
    <v-text-field
      label="Password"
      density="compact"
      v-model="state.password"
      :error-messages="errors.password"
      @input="errors.resetFor('password')"
    />
  </div>
  <div class="flex gap-4 mt-5">
    <v-btn
      color="deep-purple"
      :disabled="!buttonEnabled"
      @click="$emit('btnClick')"
      >{{ buttonLabel }}</v-btn
    >
  </div>
</template>
