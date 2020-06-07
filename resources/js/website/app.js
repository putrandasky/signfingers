window.Vue = require('vue');

Vue.component('carrousel-how-works', require('./components/CarrouselHowWorks.vue').default);

const app = new Vue({
  el: '#how-work',
});
