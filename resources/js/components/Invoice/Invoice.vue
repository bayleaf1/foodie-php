<script setup>
import OrderStatus from '../OrderStatus.vue'
import { renderPhoneNumber } from '../../utils/phoneNumber'

let { invoice, linkToProduct } = defineProps(['invoice', 'linkToProduct'])
</script>

<template>
  <v-table density="compact" class="">
    <tbody>
      <slot name="header"></slot>
      <tr>
        <td>Status:</td>
        <td><order-status :status="invoice.status" /></td>
      </tr>
      <tr>
        <td>Name:</td>
        <td>{{ invoice.customer_name }}</td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td>{{ renderPhoneNumber(invoice.customer_phone) }}</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>{{ invoice.customer_email }}</td>
      </tr>
      <tr>
        <td>City:</td>
        <td>{{ invoice.customer_city }}</td>
      </tr>
      <tr>
        <td>Address:</td>
        <td>{{ invoice.customer_address }}</td>
      </tr>
      <tr>
        <td>Price:</td>
        <td>{{ invoice.price + '$' }}</td>
      </tr>

      <tr v-for="(p, i) in invoice.products" :key="i">
        <td class="whitespace-nowrap">Product #{{ i + 1 }}:</td>
        <td>
          <router-link :to="linkToProduct(p.id)" class="underline">{{
            p.name
          }}</router-link>
          <span class="whitespace-nowrap">
            x{{ p.quantity }} = {{ p.price }}$
          </span>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
