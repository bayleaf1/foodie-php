<script setup>
import { ref, watch } from 'vue'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import GoBackButton from '../../components/GoBackButton.vue'
import OrderStatus from '../../components/OrderStatus.vue'
import getBgColorForOrderStatus from '../../utils/getBgColorForOrderStatus.js'
import { OrderStatusType } from '../../utils/enums.js'
import fetchApp from '../../api/fetchApp.js'
import endpoints from '../../api/endpoints.js'

let order = {
  id: 1,
  email: 'guest@gst.com',
  products: [
    { id: 1, quantity: 2, name: 'Letters', price: 3 },
    { id: 2, quantity: 5, name: 'Snacks', price: 7 },
  ],
  price: 10,
  status: 'confirmed',
  images: [
    {
      url: 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg',
    },
    {
      // url: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_FWF2judaujT30K9sMf-tZFhMWpgP6xCemw&s',
    },
  ],
}
let value = ref(0)
let file = ref(null)

const preview = () => {
  file.value = input0.files[0]
  img0.src = URL.createObjectURL(input0.files[0])
}
const preview2 = () => {
  img1.src = URL.createObjectURL(input1.files[0])
}

const submit = () => {
  console.log('SUBMITT', file.value)
  const formData = new FormData()
  formData.append('file', file.value)
  fetchApp({
    endpoint: '/api/resources',
    method: 'post',
    body: formData,
    onError: ({ data, status }) => {
      console.log('ERROR', status, data)
    },
    onSuccess: ({ data, status }) => {
      console.log('Succcess', status, data)
    },
  })
}
// let urls = ref([order.images[0].url, order.images[1].url])
</script>

<template>
  <go-back-button />
  <admin-layout-card classes="mt-2" :title="`Product #` + $route.params.id">
    <div class="flex gap-10">
      <div class="grow basis-[45%]">
        <v-text-field label="Name" density="compact"> </v-text-field>
        <v-number-input
          variant="outlined"
          label="Quantity"
          density="compact"
          :min="0"
          :max="10000"
          :model-value="value"
          :rules="[(v) => (isNaN(Number(v)) ? 'Must be number' : true)]"
        ></v-number-input>
        <v-textarea
          label="Description"
          density="compact"
          :max="120"
        ></v-textarea>
      </div>
      <div class="grow basis-[45%] bg-slate-400">
        <h1>Images</h1>
        <v-btn @click="submit">submit</v-btn>

        <div class="flex gap-10 mt-5">
          <input
            id="input0"
            type="file"
            :onchange="preview"
            class="opacity-0 w-0 h-0 absolute"
          />
          <input
            id="input1"
            type="file"
            :onchange="preview2"
            class="opacity-0 w-0 h-0 absolute"
          />
          <label for="input0">
            <div
              class="aspect-square border bg-white rounded-md h-[200px] relative"
            >
              <img
                v-if="order.images[0]?.url"
                :src="order.images[0]?.url"
                id="img0"
                class="w-full h-full object-contain rounded-md"
              />
              <v-icon
                v-else
                icon="mdi-plus"
                size="x-large"
                class="absolute top-[50%] left-[50%] -translate-y-[50%] -translate-x-[50%]"
              />
            </div>
          </label>
          <label for="input1">
            <div
              class="aspect-square border bg-white rounded-md h-[200px] relative"
            >
              <img
                v-if="order.images[1]?.url"
                :src="order.images[1]?.url"
                id="img1"
                class="w-full h-full object-contain rounded-md"
              />
              <v-icon
                v-else
                icon="mdi-plus"
                size="x-large"
                class="absolute top-[50%] left-[50%] -translate-y-[50%] -translate-x-[50%]"
              />
            </div>
          </label>
        </div>
      </div>
    </div>
    <div class="flex gap-4 mt-5">
      <v-btn color="deep-purple">Save</v-btn>
    </div>
  </admin-layout-card>
</template>
