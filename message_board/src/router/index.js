import { createRouter, createWebHistory } from 'vue-router'


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes:[   
    {
      path: '/',
      name: 'home',
      component: () => import('../views/HomeView.vue')
    },
    {
      path: '/my_message',
      name: 'my_message',
      component: () => import('../views/My_MessageView.vue')
    },
    {
      path: '/welcome',
      name: 'welcome',
      component: () => import('../views/LoginRegisterView.vue')
    },
  ]
})

export default router
