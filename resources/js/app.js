import Vue from 'vue'
import store from './store'
import App from './layouts/App'
import VueRouter from 'vue-router'
import routes from './routes'


Vue.use(VueRouter)

const router = new VueRouter({
    routes,
    mode: 'history'
})

window._ = require('lodash')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const app = new Vue({    el: '#app',
    router,
    store,
    render: h => h(App)
});