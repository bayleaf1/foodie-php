<script setup>
import { computed, inject, onMounted, reactive, ref, watch } from 'vue'
import endpoints from '../../api/endpoints'
import fetchApp from '../../api/fetchApp'
import Cart from '../../utils/Cart'
import cn from '../../utils/cn'
import {
  email,
  required,
  minLength,
  numeric,
  alpha,
  maxLength,
} from '@vuelidate/validators'
import useVuelidate from '@vuelidate/core'
import OrderList from '../../utils/OrderList'
import { useRoute, useRouter } from 'vue-router'
import Notificator from '../../utils/Notificator'
import OrderForm from './OrderForm.vue'

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
  name: '',
  email: 'guest@mail.com',
  phone: '1234567890',
  city: '',
  street: '',
})

watch(state, (v) => {
  console.log('state', v)
})
const resetState = () => (state.email = '')

const rules = {
  name: { required, minLength: minLength(4), maxLength: maxLength(30) },
  email: { required, email, maxLength: maxLength(40) },
  phone: {
    required,
    numeric,
    minLength: minLength(10),
  },
  city: { required, alpha, minLength: minLength(4), maxLength: maxLength(30) },
  address: { required, minLength: minLength(4), maxLength: maxLength(100) },
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
      customer_address: state.address,
      customer_name: state.name,
      customer_phone: state.phone,
      customer_city: state.city,
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
      Notificator.pushSuccess('Order was created!')
    },
  })
}
</script>
<template>
  <page-section classes="py-15">
    <circular-loader v-if="loading" />
    <div v-else>
      <div v-if="products.length">
        <div class="flex gap-5">
          <v-btn @click="clearCart()">Empty cart</v-btn>
          <v-btn v-if="selected.length" @click="clearSelectedProducts()"
            >Clear selected
          </v-btn>
        </div>
        <div class="flex gap-10 flex-col md:flex-row">
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
          <order-form
            :v$="v$"
            :state="state"
            :tryToPlaceOrder="tryToPlaceOrder"
            :orderPrice="orderPrice"
          />
        </div>
      </div>
      <p v-else class="text-center">No products was added</p>
    </div>
  </page-section>
</template>
