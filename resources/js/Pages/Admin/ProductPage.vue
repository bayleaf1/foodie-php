<script setup>
import { ref, watch } from 'vue'
import AdminLayoutCard from '../../components/AdminLayoutCard.vue'
import GoBackButton from '../../components/GoBackButton.vue'

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
    'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg',
  ],
}
let imageName0 = ref('')
let imageName1 = ref('')

const uploadImage = (reference, inputId) => () => {
  const formData = new FormData()
  formData.append('image', document.getElementById(inputId).files[0])
  fetchApp({
    endpoint: endpoints.resources,
    method: 'post',
    body: formData,
    onError: ({ data, status }) => {
      console.log('ERROR', status, data)
    },
    onSuccess: ({ data, status }) => {
      console.log('Succcess', status, data)
      reference.value = data.name
    },
  })
}

const uploadFirstImage = uploadImage(imageName0, 'input0')
const uploadSecondImage = uploadImage(imageName1, 'input1')

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
      <div class="grow basis-[45%] bg-slate-400x">
        <p class="text-xl">Images</p>
        <div class="flex gap-10 mt-[34px]">
          <input
            id="input0"
            type="file"
            :onchange="uploadFirstImage"
            class="opacity-0 w-0 h-0 absolute"
          />
          <input
            id="input1"
            type="file"
            :onchange="uploadSecondImage"
            class="opacity-0 w-0 h-0 absolute"
          />
          <label for="input0">
            <div
              class="aspect-square border bg-white rounded-md h-[200px] relative"
            >
              <img
                v-if="imageName0"
                :src="endpoints.productImage(imageName0)"
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
                v-if="imageName1"
                :src="endpoints.productImage(imageName1)"
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
      <v-btn color="deep-purple" @click="onSave()">Save</v-btn>
    </div>
  </admin-layout-card>
</template>
