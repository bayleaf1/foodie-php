<script setup>
import { computed, inject, onMounted, reactive, ref } from 'vue'
import { useRoute } from 'vue-router'
import endpoints from '../api/endpoints'
import fetchApp from '../api/fetchApp'
import Cart from '../utils/Cart'

let router = useRoute()
let productId = Number(router.params.id)

let product = ref(null)

onMounted(() => {
  fetchApp({
    endpoint: endpoints.productShowcase(productId),
    onSuccess: ({ data }) => (product.value = data.product),
  })
})

const state = reactive({
  quantity: 1,
  descriptionIsExpanded: true,
})

const price = computed(() =>
  product ? product.value.price * state.quantity : 0
)

let isValid = computed(() => !isNaN(state.quantity))

const description = computed(() =>
  product.value.description.slice(
    0,
    state.descriptionIsExpanded ? product.value.description.length : 100
  )
)

let { refreshCartSize } = inject('guestProvider')

function addToCart() {
  state.quantity = 1
  Cart.addProduct(productId, 20)
  refreshCartSize()
}
</script>
<template>
  <h1 class="text-red">Home</h1>
  <page-section :classes="'flex gap-20 flex-row'">
    <div
      v-if="product"
      class="border rounded-md shadow-md shrink-0 basis-[50%] self-start"
    >
      <v-carousel hide-delimiters class="h-fit">
        <v-carousel-item
          v-for="src in product.images"
          :key="src"
          :src="endpoints.productImage(src)"
          contain
        ></v-carousel-item>
      </v-carousel>
    </div>

    <div v-if="product" class="grow">
      <div class="mt-[100px]">
        <p class="text-3xl">{{ product.name }}</p>
        <v-divider
          :thickness="1"
          color="success"
          class="border-opacity-75 my-8"
        ></v-divider>
        <div class="flex gap-8">
          <v-number-input
            variant="outlined"
            label="Quantity"
            density="compact"
            :min="1"
            :max="product.quantity"
            v-model="state.quantity"
            class="max-w-[150px]"
            :rules="[(v) => (isNaN(Number(v)) ? 'Must be number' : true)]"
            :validation-value="val"
          ></v-number-input>
          <p class="text-3xl min-w-[80px]">$ {{ isNaN(price) ? 0 : price }}</p>
          <v-btn
            density="default"
            color="deep-purple"
            :disabled="!isValid"
            @click="addToCart()"
            >Add to cart</v-btn
          >
        </div>
        <v-divider
          :thickness="1"
          color="success"
          class="border-opacity-75 my-3 mb-7"
        ></v-divider>

        <p
          class="cursor-pointer"
          @click="state.descriptionIsExpanded = !state.descriptionIsExpanded"
        >
          {{ description }}
        </p>
      </div>
    </div>
  </page-section>
</template>
