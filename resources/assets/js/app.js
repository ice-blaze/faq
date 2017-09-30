import Vue from 'vue'
import axios from 'axios'
window.axios = require('axios');
// import urljoin from 'url-join'
var urljoin = require('url-join');

Vue.component('qas', require('./components/Qas.vue'));

import VeeValidate from "vee-validate"
Vue.component('add-qa', require('./components/AddQa.vue'));
Vue.use(VeeValidate)

const app = new Vue({
    el: '#app',
});
