<script setup>
import { computed, inject, reactive } from 'vue'
import endpoints from '../api/endpoints'
import Cart from '../utils/Cart'
import cn from '../utils/cn'
import Notificator from '../utils/Notificator'

let { product, direction } = defineProps(['product', 'direction'])
let p = { ...product }

const state = reactive({
  quantity: 1,
})

const price = computed(() => (product ? p.price * state.quantity : 0))

const isValid = computed(() => !isNaN(state.quantity))

let { refreshCartSize } = inject('guestProvider')

function addToCart() {
  Cart.addProduct(p.id, state.quantity)
  Notificator.pushSuccess('Added to cart')
  state.quantity = 1
  refreshCartSize()
}

let right = {
  banner: 'right-[0%]',
  image: 'justify-start',
}
let left = {
  banner: 'left-[0%] border-l border-brand',
  image: 'justify-end',
}
const classes = direction === 'right' ? right : left
</script>

<template>
  <div :class="cn('relative grow md:flex', classes.image)">
    <div
      class="border grow rounded-md shadow-md shrink-0 h-[350px] md:max-w-[70%] lg:max-w-[80%] bg-white self-start relative overflow-hidden"
    >
      <v-img
        aspect-ratio="16/9"
        class="w-full h-full"
        cover
        :src="endpoints.productImage(p.images[0])"
      />
    </div>
    <div
      :class="
        cn(
          'h-[300px] bg-slate-50 flex flex-col items-center transition-all  hover:shadow-lg rounded-sm md:max-w-[40%] w-[100%] md:absolute  md:top-[50%] md:-translate-y-[50%] p-5',
          classes.banner
        )
      "
    >
      <p class="text-2xl text-center text-brand font-semibold">
        {{ p.name }}
      </p>
      <p class="text-sm text-center mt-4 h-[80px] overflow-auto">
        {{ p.description }}
      </p>
      <div v-if="p.quantity">
        <div class="mt-6 flex gap-3">
          <v-number-input
            variant="outlined"
            label="Quantity"
            density="compact"
            :min="1"
            :max="p.quantity"
            v-model="state.quantity"
            class="max-w-[400px] shrink-0 min-w-[130px] grow"
            :rules="[(v) => (isNaN(Number(v)) ? 'Must be number' : true)]"
          ></v-number-input>
          <p class="text-3xl min-w-[65px] font-semibold text-brand">
            ${{ isNaN(price) ? 0 : price }}
          </p>
        </div>

        <!--  -->
        <v-btn
          density="default"
          :disabled="!isValid"
          @click="addToCart()"
          color="primary"
          >Add to cart</v-btn
        >
      </div>
      <p v-else class="mt-5 text-lg">out of stock</p>
    </div>
  </div>
</template>
