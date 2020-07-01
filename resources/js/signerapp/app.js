/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import {
  BootstrapVue,
  BootstrapVueIcons
} from 'bootstrap-vue'
import App from './components/App';

import 'vue-material-design-icons/styles.css';
import VueSignaturePad from "vue-signature-pad";
import VueMq from 'vue-mq';
import Vuex from 'vuex'
import VueSocialSharing from 'vue-social-sharing'
import {
  store
} from './store/index';
var Lang = require('lang.js');
import source from "./i18n/localization"
var lang = new Lang({
  messages: source,
  locale: window.location.pathname == '/tanda-tangan-digital' ? 'id' : 'en',
});
Vue.prototype.$filters = Vue.options.filters
Vue.prototype.$lang = lang
Vue.filter('trans', (...args) => {
  return lang.get(...args);
});

// console.log(lang.getLocale());
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(VueSignaturePad);
Vue.use(Vuex);
Vue.use(VueSocialSharing);
Vue.use(VueMq, {
  breakpoints: {
    xs: 576,
    sm: 768,
    md: 992,
    lg: 1200,
    xl: Infinity
  }
});

const app = new Vue({
  el: '#app',
  store,
  render: h => h(App),
});
