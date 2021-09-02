import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Index from './views/Index'
import Show from './views/Show'
import Login from './views/Auth/Login.vue'

const routes = [ 
    { path: '/', component: Index },
    { path: '/show', component: Show },
    { path: '/login', component: Login }
]

export default new VueRouter({
    routes,
    mode: 'history'
})