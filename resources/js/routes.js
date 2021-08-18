import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Index from './views/Index'
import Show from './views/Show'

const routes = [ 
    { path: '/', component: Index },
    { path: '/show', component: Show }
]

export default new VueRouter({
    routes,
    mode: 'history'
})