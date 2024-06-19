import { createRouter, createWebHistory } from 'vue-router'
import JwtStorage from './auth.js'
//
import LoginPage from './pages/admin/LoginPage.vue'
import OverviewPage from './pages/admin/OverviewPage.vue'
import AdminOrdersPage from './pages/admin/OrdersPage.vue'
import ProductsPage from './pages/admin/ProductsPage.vue'
import AdminLayout from './layouts/AdminLayout/AdminLayout.vue'
import GuestLayout from './layouts/GuestLayout/GuestLayout.vue'
import OrderPage from './pages/admin/OrderPage.vue'
import AdminProductPage from './pages/admin/ProductPage.vue'
import SystemUsersPage from './pages/admin/SystemUsersPage.vue'
import ProductAddPage from './pages/admin/ProductAddPage.vue'
//
import HomePage from './pages/HomePage.vue'
import ProductPage from './pages/ProductPage.vue'
import NotFoundPage from './pages/NotFoundPage.vue'
import CartPage from './pages/CartPage.vue'
import OrdersPage from './pages/OrdersPage.vue'
import { SystemUser } from './utils/SystemUser.js'

const routes = [
  {
    path: '/',
    component: GuestLayout,
    children: [
      { path: '', component: HomePage },
      { path: 'product/:id', component: ProductPage },
      { path: 'cart', component: CartPage },
      { path: 'orders', component: OrdersPage },
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
      { path: 'orders', component: AdminOrdersPage },
      { path: 'orders/:id', component: OrderPage },
      { path: 'products', component: ProductsPage },
      { path: 'products/add', component: ProductAddPage },
      { path: 'products/:id', component: AdminProductPage },
      {
        path: 'system-users',
        component: SystemUsersPage,
        meta: { resource: 'system-users-page' },
      },
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
  if (!to.meta.auth) return next()

  let logged = JwtStorage.exists()
  if (!logged) return next('/admin/login')

  let user = SystemUser.createFromLocalStorage()
  if (!to.meta.resource) return next()

  if (user.canAccess(to.meta.resource)) next()
  else next('/admin/dashboard')

  next()
})
export default router
