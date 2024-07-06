<script setup>
import PhoneTextField from '../../components/PhoneTextField.vue'

const { v$, state, orderPrice, tryToPlaceOrder } = defineProps([
  'v$',
  'state',
  'orderPrice',
  'tryToPlaceOrder',
])
</script>
<template>
  <div class="min-w-[350px] mt-0.5">
    <p class="text-xl">Order details</p>
    <div class="flex flex-col gap-1 mt-2">
      <v-text-field
        v-model="state.name"
        :error-messages="v$.name.$errors.map((e) => e.$message)"
        label="Name"
        required
        @blur="v$.name.$touch"
        @input="v$.name.$touch()"
      ></v-text-field>

      <v-text-field
        v-model="state.email"
        :error-messages="v$.email.$errors.map((e) => e.$message)"
        label="E-mail"
        required
        @blur="v$.email.$touch"
        @input="v$.email.$touch()"
      ></v-text-field>

      <phone-text-field v-model="state.phone" :v$="v$"></phone-text-field>

      <v-text-field
        v-model="state.city"
        :error-messages="v$.city.$errors.map((e) => e.$message)"
        label="City"
        required
        @blur="v$.city.$touch"
        @input="v$.city.$touch()"
      ></v-text-field>

      <v-text-field
        v-model="state.street"
        :error-messages="v$.street.$errors.map((e) => e.$message)"
        label="Street"
        required
        @blur="v$.street.$touch"
        @input="v$.street.$touch()"
      ></v-text-field>
    </div>

    <div class="flex flex-col gap-1 mt-3">
      <div class="flex justify-between">
        <p class="text-sm">Delivery:</p>
        <p class="text-sm">free</p>
      </div>

      <div class="flex justify-between mt-1">
        <p class="text-2xl">Total:</p>
        <p class="text-2xl">$ {{ orderPrice }}</p>
      </div>
      <v-btn @click="tryToPlaceOrder()" color="primary">Place order</v-btn>
    </div>
  </div>
</template>
