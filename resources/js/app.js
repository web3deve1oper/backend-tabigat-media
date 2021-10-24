import vuetify from './plugins/vuetify';
import router from "./router";
import store from './store'
import API from "./api/api"

require('./bootstrap');

window.Vue = require('vue').default;

Vue.prototype.$http = API;

Vue.component('App', require('./layout/App.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify
})
