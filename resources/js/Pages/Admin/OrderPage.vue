<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import endpoints from '../../api/endpoints.js'
import fetchApp from '../../api/fetchApp.js'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import GoBackButton from '../../components/GoBackButton.vue'
import OrderStatus from '../../components/OrderStatus.vue'
import { OrderStatusType } from '../../utils/enums.js'
import getBgColorForOrderStatus from '../../utils/getBgColorForOrderStatus.js'
import OrderDialog from './parts/OrderDialog.vue'
import Notificator from '../../utils/Notificator.js'
import { renderPhoneNumber } from '../../utils/phoneNumber.js'

let defOrder = {
  id: 1,
  invoice: null,
  customer_email: '',
  customer_name: '',
  customer_phone: '',
  customer_city: '',
  customer_address: '',
  products: [],
  status: 'created',
  price: 0,
  can_be_canceled: false,
  can_be_confirmed: false,
  can_be_finished: false,
}
let orderId = useRoute().params.id

let order = ref({ ...defOrder })
let loading = ref(true)

function fetchOrder() {
  fetchApp({
    endpoint: endpoints.order(orderId),
    onSuccess: ({ data }) => Object.assign(order.value, data.order),
    onFinally: () => {
      loading.value = false
    },
  })
}

onMounted(fetchOrder)

function tryToChangeStatus(status) {
  loading.value = true
  fetchApp({
    endpoint: endpoints.changeOrderStatus(orderId, status),
    method: 'patch',
    onSuccess: () => (fetchOrder(), Notificator.pushSuccess('Updated!')),
    onFinally: () => (loading.value = false),
  })
}
</script>

<template>
  <go-back-button />

  <admin-layout-card
    classes="mt-2"
    :title="`Order #` + orderId"
    :loading="loading"
  >
    <div class="border rounded-sm lg:w-1/3 min-w-[400px]">
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
            <td>Invoice Id:</td>
            <td class="underline">
              <router-link
                v-if="order.invoice !== ''"
                class="cursor-pointer w-full block"
                :to="'/admin/dashboard/invoices/' + order.invoice_id"
                >{{ order.invoice_id }}</router-link
              >
            </td>
          </tr>
          <tr>
            <td>Name:</td>
            <td>{{ order.customer_name }}</td>
          </tr>
          <tr>
            <td>Phone:</td>
            <td>{{ renderPhoneNumber(order.customer_phone) }}</td>
          </tr>
          <tr>
            <td>Email:</td>
            <td>{{ order.customer_email }}</td>
          </tr>
          <tr>
            <td>City:</td>
            <td>{{ order.customer_city }}</td>
          </tr>
          <tr>
            <td>Address:</td>
            <td>{{ order.customer_address }}</td>
          </tr>
          <tr>
            <td>Price:</td>
            <td>{{ order.price + '$' }}</td>
          </tr>

          <tr v-for="(p, i) in order.products" :key="i">
            <td class="whitespace-nowrap">Product #{{ i + 1 }}:</td>
            <td>
              <router-link
                :to="'/admin/dashboard/products/' + p.id"
                class="underline"
                >{{ p.name }}</router-link
              >
              <span class="whitespace-nowrap">
                x{{ p.quantity }} = {{ p.price }}$
              </span>
            </td>
          </tr>
        </tbody>
      </v-table>
    </div>
    <div class="flex gap-4 mt-5">
      <order-dialog
        title="Do you want to cancel order?"
        :onOk="() => tryToChangeStatus('cancel')"
      >
        <template v-slot="{ activatorProps }">
          <v-btn
            v-if="order.can_be_canceled"
            v-bind="activatorProps"
            :class="getBgColorForOrderStatus(OrderStatusType.CANCELED)"
            >Cancel</v-btn
          >
        </template>
      </order-dialog>
      <order-dialog
        title="Do you want to confirm order?"
        :onOk="() => tryToChangeStatus('confirm')"
      >
        <template v-slot="{ activatorProps }">
          <v-btn
            v-if="order.can_be_confirmed"
            v-bind="activatorProps"
            :class="getBgColorForOrderStatus(OrderStatusType.CONFIRMED)"
            >Confirm</v-btn
          >
        </template>
      </order-dialog>
      <order-dialog
        title="Do you want to finish order?"
        :onOk="() => tryToChangeStatus('finalize')"
      >
        <template v-slot="{ activatorProps }">
          <v-btn
            v-if="order.can_be_finished"
            v-bind="activatorProps"
            :class="getBgColorForOrderStatus(OrderStatusType.FINISHED)"
            >Finish</v-btn
          >
        </template>
      </order-dialog>
    </div>
  </admin-layout-card>
</template>
