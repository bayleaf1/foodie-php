<script setup>
import { vMaska } from 'maska/vue'
//
const { v$ } = defineProps(['v$'])
const model = defineModel()
function input(e) {
  const numbers = e.target.value.match(/\d+/g) || ['']
  model.value = numbers.join('')
  v$.phone.$touch()
}
</script>
<template>
  <v-text-field
    :modelValue="model"
    label="Phone"
    required
    type="tel"
    @input="input"
    v-maska="'(###) ###-####'"
    :error-messages="v$.phone.$errors.map((e) => e.$message)"
    @blur="v$.phone.$touch"
  ></v-text-field>
</template>
