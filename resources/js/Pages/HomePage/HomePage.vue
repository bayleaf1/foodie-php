<script setup>
import { onMounted, reactive, ref } from 'vue'
import fetchApp from '../../api/fetchApp'
import endpoints from '../../api/endpoints'
import Product from '../../components/Product.vue'
import CompactProduct from '../../components/CompactProduct.vue'
import HomePageSection from './HomePageSection.vue'

let menu = reactive({
  salad: [],
  snack: [],
})

onMounted(() => {
  fetchApp({
    endpoint: endpoints.productsMenu,
    onSuccess: ({ data }) => {
      // console.log('DATA', data, Object.assign(menu, data.menu))
      Object.assign(menu, data.menu)
    },
  })
})
</script>
<template>
  <div class="bg-image">
    <page-section id="supe" classes="flex flex-col gap-10 pt-10 pb-[80px]">
      <home-page-section id="supe" title="Superbus">
        <div class="grow basis-[45%]" v-for="(p, idx) of menu.salad" :key="idx">
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
    </page-section>

    <!-- <div class="max-w-[1314px] mx-auto flex gap-[20px]">
      <div
        v-for="(p, i) in products"
        :key="i"
        class="border max-w-[300px] rounded-3xl hover:shadow-md transition-all cursor-pointer"
      >
        <router-link :to="'/product/' + p.id">
          <div>
            <v-img
              :src="endpoints.productImage(p.images[0])"
              class="h-10 grow"
              :width="400"
              :height="300"
            />
          </div>
          <div class="p-2 px-6 flex justify-between">
            <p class="">{{ p.name || 'lalala' }}</p>
            <p class="text-red">{{ p.price }}$</p>
          </div>
        </router-link>
      </div>
    </div>
    <pre>{{ JSON.stringify(products, null, 2) }}</pre> -->
  </div>
</template>
