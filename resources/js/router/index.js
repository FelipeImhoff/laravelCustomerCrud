import { createRouter, createWebHistory } from 'vue-router'
import customerIndex from '../components/customers/Index.vue'
import customerForm from '../components/customers/Form.vue'


const routes = [
  {
    path: '/',
    name: 'customers.index',
    component: customerIndex
  },
  {
    path: '/customers/create',
    name: 'customers.create',
    component: customerForm
  },
  {
    path: '/customers/:id/edit',
    name: 'customers.edit',
    component: customerForm
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router