require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('app', require('./App.vue').default)

const app = new Vue({
    el: '#app',
});