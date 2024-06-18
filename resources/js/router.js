import { createRouter, createWebHistory } from 'vue-router'
import JwtStorage from './auth.js'
//
import LoginPage from './pages/admin/LoginPage.vue'
import OverviewPage from './pages/admin/OverviewPage.vue'
import OrdersPage from './pages/admin/OrdersPage.vue'
import ProductsPage from './pages/admin/ProductsPage.vue'
import AdminLayout from './layouts/AdminLayout/AdminLayout.vue'
import GuestLayout from './layouts/GuestLayout/GuestLayout.vue'
import OrderPage from './pages/admin/OrderPage.vue'
import AdminProductPage from './pages/admin/ProductPage.vue'
import ProductAddPage from './pages/admin/ProductAddPage.vue'
//
import HomePage from './pages/HomePage.vue'
import ProductPage from './pages/ProductPage.vue'
import NotFoundPage from './pages/NotFoundPage.vue'
import CartPage from './pages/CartPage.vue'

const routes = [
  {
    path: '/',
    component: GuestLayout,
    children: [
      { path: '', component: HomePage },
      { path: 'product/:id', component: ProductPage },
      { path: 'cart', component: CartPage },
    ],
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
      { path: 'orders/:id', component: OrderPage },
      { path: 'products', component: ProductsPage },
      { path: 'products/add', component: ProductAddPage },
      { path: 'products/:id', component: AdminProductPage },
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
