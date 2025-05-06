import { createApp } from 'vue'

import App from '@/App.vue'
import { registerPlugins } from '@core/utils/plugins'


import '@core/scss/template/index.scss'
import '@layouts/styles/index.scss'


const app = createApp(App)
const pinia = createPinia()

registerPlugins(app)



app.use(pinia)
app.mount('#app')
