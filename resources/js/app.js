import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
// Vuetify
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import AdminLayout from './layouts/AdminLayout/AdminLayout.vue'
import SystemUserProvider from './providers/SystemUserProvider.vue'

const vuetify = createVuetify({
  components,
  directives,
})
createApp(App)
  .component('AdminLayout', AdminLayout)
  .component('SystemUserProvider', SystemUserProvider)
  .use(router)
  .use(vuetify)
  .mount('#app')
