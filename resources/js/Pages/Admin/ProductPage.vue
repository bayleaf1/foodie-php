<script setup>
import { ref, watch } from 'vue'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import GoBackButton from '../../components/GoBackButton.vue'
import OrderStatus from '../../components/OrderStatus.vue'
import getBgColorForOrderStatus from '../../utils/getBgColorForOrderStatus.js'
import { OrderStatusType } from '../../utils/enums.js'

let order = {
  id: 1,
  email: 'guest@gst.com',
  products: [
    { id: 1, quantity: 2, name: 'Letters', price: 3 },
    { id: 2, quantity: 5, name: 'Snacks', price: 7 },
  ],
  price: 10,
  status: 'confirmed',
}
</script>

<template>
  <go-back-button />

  <admin-layout-card classes="mt-2" :title="`Product #` + $route.params.id">
    <div class="border rounded-sm lg:w-1/3">
      <v-table density="compact">
        <tbody>
          <tr>
            <td>Id:</td>
            <td>{{ order.id }}</td>
          </tr>
          <tr>
            <td>Status:</td>
            <td><order-status :status="order.status" /></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td>{{ order.email }}</td>
          </tr>
          <tr>
            <td>Price:</td>
            <td>{{ order.price + '$' }}</td>
          </tr>

          <tr v-for="(p, i) in order.products" :key="i">
            <td>Product #{{ i + 1 }}</td>
            <td>
              <router-link to="/admin/dashboard/orders" class="underline">{{
                p.name
              }}</router-link>
              x{{ p.quantity }} = {{ p.price }}$
            </td>
          </tr>
        </tbody>
      </v-table>
    </div>
    <div class="flex gap-4 mt-5">
      <v-btn :class="getBgColorForOrderStatus(OrderStatusType.CANCELED)"
        >Cancel</v-btn
      >
      <v-btn :class="getBgColorForOrderStatus(OrderStatusType.CONFIRMED)"
        >Confirm</v-btn
      >
      <v-btn :class="getBgColorForOrderStatus(OrderStatusType.FINISHED)"
        >Finish</v-btn
      >
    </div>
  </admin-layout-card>
</template>
