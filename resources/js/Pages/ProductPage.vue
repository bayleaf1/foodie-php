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

const description = computed(() => {
  return product.value.description
  let previewSize = 100
  let len = product.value.description.length
  let suffix = state.descriptionIsExpanded && len > previewSize ? '...' : ''
  return (
    product.value.description.slice(
      0,
      state.descriptionIsExpanded ? len : previewSize
    ) + suffix
  )
})

let { refreshCartSize } = inject('guestProvider')

function addToCart() {
  Cart.addProduct(productId, state.quantity)
  state.quantity = 1
  refreshCartSize()
}
</script>
<template>
  <page-section :classes="'flex gap-20 flex-row py-15'">
    <div
      v-if="product"
      class="border rounded-md shadow-md shrink-0 basis-[50%] self-start aspect-video"
    >
      <v-img
        :src="endpoints.productImage(product.images[0])"
        cover
        class="w-full h-full"
      />
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
            color="primary"
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
