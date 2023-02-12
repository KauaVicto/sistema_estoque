import { createRouter, createWebHistory } from 'vue-router'
import { middlewares } from '../middlewares';


const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '../views/LoginView'),
    beforeEnter: middlewares.LoginMiddleware
  },
  {
    path: '/',
    name: 'home',
    component: () => import(/* webpackChunkName: "home" */ '../views/HomeView'),
    beforeEnter: middlewares.AuthMiddleware
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
