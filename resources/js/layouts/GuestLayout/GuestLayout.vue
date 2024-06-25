<script setup>
import { provide, ref } from 'vue'
import Cart from '../../utils/Cart'
import AppLogo from '../../components/AppLogo.vue'
let cartSize = ref(Cart.size())

provide('guestProvider', {
  refreshCartSize: () => (cartSize.value = Cart.size()),
})
const menuItems = [
  { title: 'Supe', hash: 'supe' },
  { title: 'Snacks', hash: 'snacks' },
  { title: 'About us', hash: 'aboutUs' },
]
</script>

<template>
  <div class="fixed top-0 left-0 right-0 z-20">
    <div class="bg-deep-purple h-[30px]">
      <page-section classes="h-full flex items-center justify-center">
        <router-link to="/admin/login">
          <p class="text-center text-white">Admin panel --></p>
        </router-link>
      </page-section>
    </div>
    <div
      class="bg-white h-[60px] shadow-xlx shadow-[0px_0px_17px_5px_#00000024]"
    >
      <page-section classes="flex justify-between items-center h-full">
        <div class="flex gap-6 items-center">
          <router-link to="/">
            <app-logo />
          </router-link>
          <div class="text-deep-purple font-medium cursor-pointer">
            Menu
            <v-menu activator="parent">
              <v-list>
                <v-list-item
                  v-for="(item, index) in menuItems"
                  :key="index"
                  :value="index"
                >
                  <a :href="'/#' + item.hash">
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                  </a>
                </v-list-item>
              </v-list>
            </v-menu>
          </div>
        </div>
        <div class="flex gap-2 md:gap-8">
          <div class="flex items-center flex-col">
            <v-icon icon="mdi-truck-delivery-outline" size="20"></v-icon>
            <p class="text-[11px]">Delivery</p>
            <v-tooltip activator="parent" location="bottom"
              >Delivery is free and works from 11:00 to 19:00
            </v-tooltip>
          </div>
          <router-link to="/orders" class="flex items-center flex-col">
            <v-icon icon="mdi-apps" size="20"></v-icon>
            <p class="text-[11px]">Orders</p>
          </router-link>
          <router-link to="/cart" class="flex items-center flex-col">
            <v-badge v-if="cartSize" :content="cartSize" color="red">
              <v-icon icon="mdi-cart-outline" size="20"></v-icon>
            </v-badge>
            <v-icon v-else icon="mdi-cart-outline" size="20"></v-icon>
            <p class="text-[11px]">Cart</p>
          </router-link>
        </div>
      </page-section>
    </div>
  </div>
  <div class="h-[90px]"></div>

  <div class="min-h-[calc(100vh-210px)]">
    <router-view></router-view>
  </div>
  <div class="bg-white h-[150px] shadow-[0px_5px_17px_5px_#00000024]">
    <page-section classes="flex justify-center items-center h-full">
      <div class="w-min-content flex flex-col items-center">
        <app-logo />
        <div class="flex gap-10 mt-2">
          <div class="flex gap-2 items-center">
            <v-icon icon="mdi-phone" size="20" color="deep-purple"></v-icon>
            <p class="text-deep-purple font-semibold">+79 000 000</p>
          </div>
          <div class="flex gap-2 items-center">
            <v-icon icon="mdi-email" size="20" color="deep-purple"></v-icon>
            <p class="text-deep-purple font-semibold">info@foodie.com</p>
          </div>
        </div>
      </div>
    </page-section>
  </div>
</template>
