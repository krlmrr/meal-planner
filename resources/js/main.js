import Vue from 'vue'
import store from './store'
import App from './App'
import router from './routes'

window._ = require('lodash')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const app = new Vue({ 
    el: '#app',
    router,
    store,
    render: h => h(App)
});