<script setup>
import { onMounted, reactive, ref } from 'vue'
import fetchApp from '../../api/fetchApp'
import endpoints from '../../api/endpoints'
import Product from '../../components/Product.vue'
import CompactProduct from '../../components/CompactProduct.vue'
import HomePageSection from './HomePageSection.vue'
// import Echo from 'laravel-echo'

let menu = reactive({
  salad: [],
  snack: [],
})
let msg = ref({})

onMounted(() => {
  // Echo.channel('orders.' + '9')
  //   .subscribed(function () {
  //     console.log('subscribed To Channel')
  //   })
  //   .listen('.order.updated', (e) => {
  //     console.log('MSGx', e)

  //     msg.value = 'updated'
  //   })
  // .leaving(() => {
  //   console.log('LEAVEEE')
  // })

  fetchApp({
    endpoint: endpoints.productsMenu,
    onSuccess: ({ data }) => {
      // console.log('DATA', data, Object.assign(menu, data.menu))
      Object.assign(menu, data.menu)
    },
  })
})

const sendMsg = () => {
  fetchApp({
    endpoint: '/api/products/message',
    onSuccess: ({ data }) => {
      msg.value = data
      // console.log('DATA', data, Object.assign(menu, data.menu))
      // Object.assign(menu, data.menu)
    },
  })
}
</script>
<template>
  <div>
    <page-section id="supe" classes="flex flex-col gap-10 pt-10 pb-[80px]">
      <v-btn @click="sendMsg()">xMSG</v-btn>
      <p>{{ JSON.stringify(msg, null, 2) }}</p>

      <home-page-section id="supe" title="Superbusx">
        <div
          class="grow md:basis-[60%] lg:basis-[45%]"
          v-for="(p, idx) of menu.salad"
          :key="idx"
        >
          <compact-product
            :product="p"
            :direction="idx % 2 ? 'left' : 'right'"
          />
        </div>
      </home-page-section>
      <home-page-section id="snacks" title="Snacks">
        <div class="grow basis-[60%]" v-for="(p, idx) of menu.snack" :key="idx">
          <product :product="p" :direction="idx % 2 ? 'left' : 'right'" />
        </div>
      </home-page-section>

      <home-page-section id="aboutUs" title="About us">
        <div class="flex gap-10">
          <div class="grow basis-[60%] rounded-lg">
            <v-img
              class="rounded-lg"
              :height="400"
              src="/static-images/foods.jpg"
              cover
            />
          </div>
          <div class="grow w-full basis-[40%]">
            <p class="grow">
              Welcome to
              <a href="/" class="text-deep-purple text-xl">Foodie</a>
              , where passion for food meets convenience at your doorstep.
              Founded with a mission to redefine how you experience dining, we
              are dedicated to delivering exceptional meals from your favorite
              local restaurants directly to you. At
              <a href="/" class="text-deep-purple text-xl">Foodie</a>
              , we believe that good food should be accessible to everyone, no
              matter where you are. Whether you're craving comfort food,
              exploring new flavors, or simply seeking a convenient meal
              solution, we've got you covered. Backed by a team of food
              enthusiasts and logistics experts, we ensure that your order is
              delivered promptly and with the utmost care. We prioritize
              quality, reliability, and customer satisfaction in every aspect of
              our service. Join us in celebrating the joy of great food,
              hassle-free ordering, and the delight of discovering new culinary
              delights. Experience the convenience and flavors that
              <a href="/" class="text-deep-purple text-xl">Foodie</a>
              brings to your table today.
            </p>
          </div>
        </div>
      </home-page-section>
    </page-section>
  </div>
</template>
