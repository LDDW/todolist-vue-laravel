import { createApp } from 'vue'
import App from './App.vue'
import router from './Router'
import './style.css'
import './axios.js'

const app = createApp(App)

app.use(router)
app.mount('#app')
