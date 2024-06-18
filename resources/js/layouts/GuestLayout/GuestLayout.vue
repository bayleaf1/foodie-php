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
      <div>
        <router-link to="/"> Foodie </router-link>
      </div>
      <div>
        <router-link to="/cart">
          <v-badge v-if="cartSize" :content="cartSize" color="red">
            <v-icon icon="mdi-cart-outline" size="default"></v-icon>
          </v-badge>
          <v-icon v-else icon="mdi-cart-outline" size="default"></v-icon>
        </router-link>
      </div>
    </page-section>
  </div>
  <div class="min-h-[calc(100vh-210px)]">
    <router-view></router-view>
  </div>
  <div class="bg-slate-100 h-[150px]">bottom</div>
</template>
