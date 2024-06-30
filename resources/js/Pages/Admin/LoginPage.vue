<script setup>
import { reactive, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import fetchApp from '../../api/fetchApp'
import JwtStorage from '../../auth'
import { useRouter } from 'vue-router'

const initialState = {
  email: 'admin@admin.com',
  password: 'qwer1234',
}

const state = reactive({
  ...initialState,
})

const rules = {
  email: { required, email },
  password: { required },
}

const v$ = useVuelidate(rules, state)

let extraErrors = ref({
  email: '',
  password: '',
  resetFor(field) {
    this[field] = ''
  },
})

function onInput(field) {
  v$.value[field].$touch()
  extraErrors.value.resetFor(field)
}

let router = useRouter()

async function onLogin() {
  let isValid = await v$.value.$validate()
  if (isValid) {
    fetchApp({
      endpoint: '/api/auth/login/system-user',
      method: 'post',
      body: {
        email: state.email,
        password: state.password,
      },
      onSuccess: ({ data }) => {
        JwtStorage.save(data.accessToken)
        router.push('/admin/dashboard')
      },
      onError: ({ status, data }) => {
        if (status === 422)
          Object.entries(data.errors).forEach(([key, [msg]]) => {
            extraErrors.value[key] = msg
          })
      },
    })
  }
}
</script>

<template>
  <div class="min-h-screen bg-brand box-border pt-[20vh]">
    <form class="rounded-md p-5 mx-auto box-border bg-white max-w-96">
      <h1 class="text-center text-3xl mb-3">Login</h1>
      <form class="flex flex-col gap-5">
        <v-text-field
          v-model="state.email"
          :error-messages="
            v$.email.$errors.map((e) => e.$message).toString() ||
            extraErrors.email
          "
          label="E-mail"
          required
          @blur="v$.email.$touch"
          @input="onInput('email')"
        ></v-text-field>
        <v-text-field
          v-model="state.password"
          :error-messages="
            v$.password.$errors.map((e) => e.$message).toString() ||
            extraErrors.password
          "
          label="Password"
          required
          type="password"
          @blur="v$.password.$touch"
          @input="onInput('password')"
        ></v-text-field>

        <v-btn class="w-full" color="primary" @click="onLogin"> Login </v-btn>
      </form>
    </form>
  </div>
</template>
