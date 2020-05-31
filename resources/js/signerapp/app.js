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
import {
  store
} from './store/index';
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(VueSignaturePad);
Vue.use(Vuex)
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
