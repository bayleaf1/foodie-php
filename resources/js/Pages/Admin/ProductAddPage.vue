<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import endpoints from '../../api/endpoints.js'
import fetchApp from '../../api/fetchApp.js'
import AdminInnerTemplate from './parts/AdminInnerTemplate.vue'

const initialState = {
  name: 'Product ' + Date.now(),
  price: 0,
  quantity: 0,
  description: 'Desc ' + Date.now(),
  images: [],
}
let state = ref({ ...initialState })

let errors = ref({
  ...Object.fromEntries(Object.keys(initialState).map((k) => [k, ''])),
  resetFor(field) {
    this[field] = ''
  },
})

const uploadImage = (inputId, idx) => () => {
  const formData = new FormData()
  formData.append('image', document.getElementById(inputId).files[0])
  errors.value.resetFor('images')
  fetchApp({
    endpoint: '/api/resources',
    method: 'post',
    body: formData,
    onError: ({ data, status }) => {
      console.log('ERROR', status, data)
    },
    onSuccess: ({ data, status }) => {
      console.log('Succcess', status, data)
      state.value.images[idx] = data.name
    },
  })
}

const uploadFirstImage = uploadImage('input0', 0)
const uploadSecondImage = uploadImage('input1', 1)

let router = useRouter()
function onSave() {
  const body = { ...state.value }
  fetchApp({
    endpoint: endpoints.products,
    method: 'post',
    body,
    onError: ({ data, status }) => {
      console.log('ERROR', status, data)
      if (status === 422) {
        Object.entries(data.errors).forEach(([key, [msg]]) => {
          errors.value[key] = msg
        })
      }
    },
    onSuccess: ({ data, status }) => {
      console.log('Succcess', status, data, JSON.stringify(data, null, 2))
      // router.replace('/admin/dashboard/products/' + data.product_id)
    },
  })
}
</script>

<template>
  <admin-inner-template title="Add new product">
    <div class="flex gap-10">
      <div class="grow basis-[45%] flex flex-col gap-2">
        <v-text-field
          label="Name"
          density="compact"
          v-model="state.name"
          :error-messages="errors.name"
          @input="errors.resetFor('name')"
        >
        </v-text-field>
        <div class="flex gap-10">
          <v-number-input
            variant="outlined"
            label="Price"
            density="compact"
            :min="0"
            :max="10000"
            v-model="state.price"
            :rules="[(v) => (isNaN(Number(v)) ? 'Must be number' : true)]"
            :error-messages="errors.price"
            @update:modelValue="errors.resetFor('price')"
          ></v-number-input>
          <v-number-input
            variant="outlined"
            label="Quantity"
            density="compact"
            :min="0"
            :max="10000"
            v-model="state.quantity"
            :rules="[(v) => (isNaN(Number(v)) ? 'Must be number' : true)]"
            :error-messages="errors.quantity"
            @update:modelValue="errors.resetFor('quantity')"
          ></v-number-input>
        </div>

        <v-textarea
          label="Description"
          density="compact"
          :max="120"
          v-model="state.description"
          :error-messages="errors.description"
          @input="errors.resetFor('description')"
        ></v-textarea>
      </div>
      <div class="grow basis-[45%] bg-slate-400x">
        <p class="text-xl mt-4">Images</p>
        <div class="flex gap-10 mt-[26px]">
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
                v-if="state.images[0]"
                :src="endpoints.productImage(state.images[0])"
                id="img0"
                class="w-full h-full object-contain rounded-md"
              />
              <div
                v-else
                class="absolute top-[50%] left-[50%] -translate-y-[50%] -translate-x-[50%]"
              >
                <v-icon icon="mdi-plus" size="x-large" />
              </div>
            </div>
          </label>
          <label for="input1">
            <div
              class="aspect-square border bg-white rounded-md h-[200px] relative"
            >
              <img
                v-if="state.images[1]"
                :src="endpoints.productImage(state.images[1])"
                id="img1"
                class="w-full h-full object-contain rounded-md"
              />
              <div
                v-else
                class="absolute top-[50%] left-[50%] -translate-y-[50%] -translate-x-[50%]"
              >
                <v-icon icon="mdi-plus" size="x-large" />
              </div>
            </div>
          </label>
        </div>
        <p v-if="errors.images" class="text-[rgb(176,0,32)] text-[12px] pt-1">
          {{ errors.images }}
        </p>
      </div>
    </div>
    <div class="flex gap-4 mt-5">
      <v-btn color="deep-purple" @click="onSave()">Save</v-btn>
    </div>
  </admin-inner-template>
</template>
