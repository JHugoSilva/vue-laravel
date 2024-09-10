import { createApp } from 'vue'
import { MaskInput } from "vue-mask-next";

import 'sweetalert2/src/sweetalert2.scss'
import App from './App.vue'
import router from './router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import 'vue3-toastify/dist/index.css';


const app = createApp(App)

app.use(router)
app.component("MaskInput", MaskInput);
app.mount('#app')
