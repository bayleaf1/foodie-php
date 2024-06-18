<script setup>
import { computed, inject, onMounted, reactive, ref } from 'vue'
import endpoints from '../api/endpoints'
import fetchApp from '../api/fetchApp'
import Cart from '../utils/Cart'
import cn from '../utils/cn'
import { email, required } from '@vuelidate/validators'
import useVuelidate from '@vuelidate/core'
import OrderList from '../utils/OrderList'
import { useRoute, useRouter } from 'vue-router'

let products = ref([])
let selected = ref([])
let loading = ref(true)

let orderPrice = computed(() =>
  products.value
    .filter((p) => p.available)
    .reduce((acc, value) => acc + value.price, 0)
)

const resetCart = () => Cart.empty()

onMounted(() => {
  fetchApp({
    endpoint: endpoints.cart,
    method: 'post',
    body: Cart.retrieve().products,
    onSuccess: ({ data }) => (products.value = data.products),
    onFinally: () => (loading.value = false),
  })
})

let { refreshCartSize } = inject('guestProvider')

function clearCart() {
  resetCart()
  refreshCartSize()
  products.value = []
  selected.value = []
  v$.value.$reset()
}

function clearSelectedProducts() {
  Cart.removeProductsById(selected.value)
  refreshCartSize()
  products.value = filterProducts()
  selected.value = []
  v$.value.$reset()

  function filterProducts() {
    let filteredProducts = products.value
    selected.value.forEach((id) => {
      filteredProducts = filteredProducts.filter((p) => p.id !== id)
    })
    return filteredProducts
  }
}

const state = reactive({
  email: '',
})
const resetState = () => (state.email = '')

const rules = {
  email: { required, email },
}
const v$ = useVuelidate(rules, state)
const router = useRouter()
async function tryToPlaceOrder() {
  let isValid = await v$.value.$validate()
  if (!isValid) return
  fetchApp({
    endpoint: endpoints.orders,
    method: 'post',
    body: {
      email: state.email,
      items: products.value.map((p) => ({
        product_id: p.id,
        quantity: p.quantity,
      })),
    },
    onSuccess: ({ data }) => {
      resetCart()
      refreshCartSize()
      resetState()
      products.value = []
      v$.value.$reset()
      OrderList.addOrderId(data.order_id)
      router.push('/orders')
    },
  })
}
</script>
<template>
  <page-section classes="pt-20">
    <circular-loader v-if="loading" />
    <div v-else>
      <div v-if="products.length">
        <div class="flex gap-5">
          <v-btn @click="clearCart()">Empty cart</v-btn>
          <v-btn
            color="deep-purple"
            v-if="selected.length"
            @click="clearSelectedProducts()"
            >Clear selected
          </v-btn>
        </div>
        <div class="flex gap-10">
          <div class="grow">
            <div>
              <div
                v-for="(p, idx) in products"
                :class="
                  cn(
                    'flex gap-5 border rounded-sm shadow p-2 mt-2',
                    !p.available && 'opacity-50'
                  )
                "
                :key="idx"
              >
                <v-checkbox
                  v-model="selected"
                  label=""
                  :value="p.id"
                ></v-checkbox>
                <div class="">
                  <v-img
                    class="w-[100px] h-[100px] rounded-sm grow-0"
                    cover
                    :src="endpoints.productImage(p.image)"
                  ></v-img>
                </div>

                <div class="grow">
                  <div class="flex justify-between grow">
                    <router-link :to="'/product/' + p.id">
                      <p class="">{{ p.name }}</p>
                    </router-link>
                    <p class="text-2xl">$ {{ p.price }}</p>
                  </div>
                  <p class="text-xs">Quantity: {{ p.quantity }}</p>

                  <p v-if="!p.available" class="mt-4 text-red">UNAVAILABLE</p>
                </div>
              </div>
            </div>
          </div>
          <div class="min-w-[350px] mt-0.5">
            <p class="text-xl">Order details</p>
            <div class="flex flex-col gap-1 mt-2">
              <v-text-field
                v-model="state.email"
                :error-messages="v$.email.$errors.map((e) => e.$message)"
                label="E-mail"
                required
                @blur="v$.email.$touch"
                @input="v$.email.$touch()"
              ></v-text-field>
            </div>

            <div class="flex flex-col gap-1">
              <div class="flex justify-between">
                <p class="text-sm">Delivery:</p>
                <p class="text-sm">free</p>
              </div>

              <div class="flex justify-between">
                <p class="text-2xl">Total:</p>
                <p class="text-2xl">$ {{ orderPrice }}</p>
              </div>
              <v-btn @click="tryToPlaceOrder()" color="deep-purple w-full"
                >Place order</v-btn
              >
            </div>
          </div>
        </div>
      </div>
      <p v-else class="text-center">No products was added</p>
    </div>
  </page-section>
</template>
