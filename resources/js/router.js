import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './pages/HomePage.vue'
import NotFoundPage from './pages/NotFoundPage.vue'
import LoginPage from './pages/admin/LoginPage.vue'
import OverviewPage from './pages/admin/OverviewPage.vue'
import OrdersPage from './pages/admin/OrdersPage.vue'
import ProductsPage from './pages/admin/ProductsPage.vue'
import JwtStorage from './auth.js'
import AdminLayout from './layouts/AdminLayout/AdminLayout.vue'

const routes = [
  {
    path: '/',
    component: HomePage,
  },
  {
    path: '/admin/login',
    component: LoginPage,
  },
  {
    path: '/admin/dashboard',
    meta: { auth: true },
    component: AdminLayout,
    children: [
      { path: '', component: OverviewPage },
      { path: 'orders', component: OrdersPage },
      { path: 'products', component: ProductsPage },
    ],
  },
  {
    path: '/:pathMatch(.*)*',
    component: NotFoundPage,
  },
]
const router = createRouter({
  history: createWebHistory(),
  routes,
})
router.beforeEach((to, from, next) => {
  if (to.meta.auth) {
    let logged = JwtStorage.exists()
    if (logged) next()
    else next('/')
  } else next()
})
export default router
