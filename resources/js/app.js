import Vue from 'vue'
import store from './store'
import VueRouter from 'vue-router'
import App from './layouts/App'
import Index from './views/Index'

Vue.use(VueRouter)

const routes = [ 
    { path: '/', component: Index }
]

const router = new VueRouter({
    routes,
    mode: 'history'
})

window._ = require('lodash')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});