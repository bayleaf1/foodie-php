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

let defOrder = {
  id: 1,
  email: '',
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
              <router-link
                :to="'/admin/dashboard/products/' + p.id"
                class="underline"
                >{{ p.name }}</router-link
              >
              x{{ p.quantity }} = {{ p.price }}$
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
