import Vue from 'vue'
import store from './store'
import router from './routes'
import App from './App'

window._ = require('lodash')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.withCredentials = true

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
