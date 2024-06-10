import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './Pages/HomePage.vue'
import LoginPage from './Pages/Admin/LoginPage.vue'
import DashboardPage from './Pages/Admin/DashboardPage.vue'
import JwtStorage from './auth.js'
const routes = [
  {
    path: '/',
    component: HomePage,
    children: [
      //   {
      //     path: '',
      //     name: 'Home',
      //     component: () => import('@/pages/Home.vue'),
      //   },
      //   {
      //     path: '/about',
      //     name: 'About',
      //     component: () => import('@/pages/About.vue'),
      //   },
    ],
  },
  {
    path: '/admin/login',
    component: LoginPage,
  },
  {
    path: '/admin/dashboard',
    component: DashboardPage,
    meta: { auth: true },
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
