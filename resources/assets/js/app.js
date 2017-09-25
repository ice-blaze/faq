import Vue from 'vue'
import axios from 'axios'
window.axios = require('axios');
// import urljoin from 'url-join'
var urljoin = require('url-join');

Vue.component('qas', require('./components/Qas.vue'));
const app = new Vue({
    el: '#app',
});
