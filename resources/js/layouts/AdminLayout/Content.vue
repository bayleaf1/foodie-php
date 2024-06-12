<script setup>
import { inject, ref, watchEffect } from 'vue'
import JwtStorage from '../../auth'

let { systemUser } = inject('system-user-provider', {})

function logout() {
  JwtStorage.remove()
  location.reload()
}
</script>
<template>
  <div class="flex gap-12">
    <v-card>
      <v-layout>
        <v-navigation-drawer class="bg-deep-purple" theme="dark" permanent>
          <v-list color="transparent" class="h-full">
            <div class="flex flex-col h-full justify-between">
              <div class="">
                <h1 class="text-3xl mt-2 ml-4 mb-2">Foodie</h1>
                <router-link to="/admin/dashboard">
                  <v-list-item
                    prepend-icon="mdi-view-dashboard"
                    title="Overview"
                  ></v-list-item>
                </router-link>
                <router-link to="/admin/dashboard/orders">
                  <v-list-item
                    prepend-icon="mdi-order-bool-ascending-variant"
                    title="Orders"
                  ></v-list-item>
                </router-link>
              </div>

              <div class="align-bottom">
                <v-list-item
                  prepend-icon="mdi-account-box"
                  :title="systemUser.name()"
                ></v-list-item>
              </div>
            </div>
          </v-list>

          <template v-slot:append>
            <div class="pa-2">
              <v-btn block @click="logout"> Logout </v-btn>
            </div>
          </template>
        </v-navigation-drawer>
        <v-main style="height: 400px"></v-main>
      </v-layout>
    </v-card>
    <div class="m-10 w-full">
      <router-view></router-view>
    </div>
  </div>
</template>
