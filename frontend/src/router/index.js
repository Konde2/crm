import { createRouter, createWebHistory } from 'vue-router'
import KanbanView from '../views/KanbanView.vue'
import LoginView from '../views/LoginView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: KanbanView, meta: { requiresAuth: true } },
    { path: '/login', component: LoginView },
  ]
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else {
    next()
  }
})

export default router