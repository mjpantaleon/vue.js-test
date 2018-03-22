/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueSession from 'vue-session';
import router from './router';
import store from './store';
import Datatable from 'vue2-datatable-component';
import BootstrapVue from 'bootstrap-vue';
import error from './components/error.vue';
import http from './http';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueSession);
Vue.use(Datatable);
Vue.use(BootstrapVue);
Vue.prototype.$http = http;

Vue.component('start', require('./components/Start.vue'));
Vue.component('error',error);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    template: `<start></start>`,
    router,
    store
});

window.app = app;