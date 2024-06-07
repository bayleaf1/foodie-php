import './bootstrap'
import { createApp } from 'vue'
import AppText from './components/AppText'

const app = createApp({
  components: {
    AppText,
  },
})

app.mount('#app')
