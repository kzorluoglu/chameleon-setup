import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import store from '../store'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/checksystemrequirements',
    name: 'CheckSystemRequirements',
    component: () => import(/* webpackChunkName: "CheckSystemRequirements" */ '../views/CheckSystemRequirements.vue')
  },
  {
    path: '/licence',
    name: 'Licence',
    component: () => import(/* webpackChunkName: "licence" */ '../views/Licence.vue')
  },
  {
    path: '/checkdatabase',
    name: 'CheckDatabase',
    component: () => import(/* webpackChunkName: "CheckDatabase" */ '../views/CheckDatabase.vue')
  },
  {
    path: '/installdatabase',
    name: 'InstallDatabase',
    component: () => import(/* webpackChunkName: "InstallDatabase" */ '../views/InstallDatabase.vue')
  },
  {
    path: '/createadmin',
    name: 'CreateAdmin',
    component: () => import(/* webpackChunkName: "CreateAdmin" */ '../views/CreateAdmin.vue')
  },
  {
    path: '/completed',
    name: 'Completed',
    component: () => import(/* webpackChunkName: "Completed" */ '../views/Completed.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {

  let allowedRouteNames = ['Home', 'CheckSystemRequirements', 'Licence', 'CheckDatabase']

  if (allowedRouteNames.includes(to.name) === false && store.state.mysql.connection.connection === false) {
    return next({ path: "/" });
   }
  next();
});

export default router
