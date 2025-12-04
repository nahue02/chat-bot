import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import Vuesax from 'vuesax-alpha'
import 'vuesax-alpha/dist/index.css'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'


createApp(App)
    .use(router)
    .use(Vuesax)
    .mount('#app')
