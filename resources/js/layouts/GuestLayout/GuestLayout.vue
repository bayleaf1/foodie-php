<script setup>
import { provide, ref } from 'vue'
import Cart from '../../utils/Cart'
let cartSize = ref(Cart.size())

provide('guestProvider', {
  refreshCartSize: () => (cartSize.value = Cart.size()),
})
</script>

<template>
  <div class="bg-slate-100 h-[60px]">
    <page-section classes="flex justify-between items-center h-full">
      <div></div>
      <div>
        <v-badge v-if="cartSize" :content="cartSize" color="red">
          <v-icon icon="mdi-cart-outline" size="default"></v-icon>
        </v-badge>
        <v-icon v-else icon="mdi-cart-outline" size="default"></v-icon>
      </div>
    </page-section>
  </div>
  <router-view></router-view>
  <div class="bg-slate-100 h-[100px]">bottom</div>
</template>
