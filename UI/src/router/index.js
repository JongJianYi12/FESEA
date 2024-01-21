import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

import StudentView from '../views/Students/View.vue'
import StudentViewSingle from '../views/Students/ViewSingle.vue'
import StudentCreate from '../views/Students/Create.vue'
import StudentEdit from '../views/Students/Update.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/',
      name: 'students',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: StudentView
    },
    {
      path: '/students/:id',
      name: 'studentViewSingle',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: StudentViewSingle
    },
    {
      path: '/students/create',
      name: 'studentCreate',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: StudentCreate
    },
    {
      path: '/students/:id/edit',
      name: 'studentEdit',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: StudentEdit
    }
  ]
})

export default router
