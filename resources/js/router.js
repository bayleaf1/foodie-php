import { createRouter, createWebHistory } from 'vue-router'
import HomePage from './Pages/HomePage.vue'
import LoginPage from './Pages/Admin/LoginPage.vue'

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
]
const router = createRouter({
  history: createWebHistory(),
  routes,
})
export default router
