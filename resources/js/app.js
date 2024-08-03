import './bootstrap'
import Swal from 'sweetalert2'
import '@fortawesome/fontawesome-free/css/all.css'
import { createApp } from 'vue'
import app from './components/App.vue'
import router from './router'

window.Swal = Swal
const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true
})

window.toast = toast
createApp(app).use(router).mount('#app')