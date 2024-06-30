// Vuetify
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { VNumberInput } from 'vuetify/labs/components'
import './bootstrap'
// import './echo';
// app
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import AdminLayout from './layouts/AdminLayout/AdminLayout.vue'
import GuestLayout from './layouts/GuestLayout/GuestLayout.vue'
import SystemUserProvider from './providers/SystemUserProvider.vue'
import PageSection from './layouts/PageSection.vue'
import CircularLoader from './components/CircularLoader.vue'
import ToastPlugin from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-bootstrap.css'
//
const vuetify = createVuetify({
  components: { ...components, VNumberInput },
  directives,
  theme: {
    defaultTheme: 'customTheme',
    themes: {
      customTheme: {
        dark: false,
        colors: {
          primary: '#E08D79',
          surface: '#E08D79',
          background: '#FFFFFF',
          surface: '#FFFFFF',
          // // primary: '#6200EE',
          'primary-darken-1': 'red', //icons
          secondary: '#03DAC6',
          'secondary-darken-1': '#018786',
          error: '#B00020',
          info: '#000',
          success: '#4CAF50',
          warning: '#FB8C00',
        },
      },
    },
  },
})
createApp(App)
  .component('AdminLayout', AdminLayout)
  .component('GuestLayout', GuestLayout)
  .component('PageSection', PageSection)
  .component('CircularLoader', CircularLoader)
  .component('SystemUserProvider', SystemUserProvider)
  .use(ToastPlugin)
  .use(router)
  .use(vuetify)
  .mount('#app')
