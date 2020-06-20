<template>

  <div class="row">
    <div class="col-lg-6 mb-3">
      <!-- <div class="w-100 text-warning text-center">
        <h3>
          <strong>
            {{'howWork.title' | trans}}
          </strong>

        </h3>
      </div> -->
      <div class="h-100 pt-5">

        <div v-show="this.currentIndex == 0">
          <h5 class="text-warning">
            {{'howWork.1.title' | trans}}
          </h5>
          <p class="text-white">
            {{'howWork.1.subtitle' | trans}}
          </p>
        </div>
        <div v-show="this.currentIndex == 1">
          <h5 class="text-warning">
            {{'howWork.2.title' | trans}}
          </h5>
          <p class="text-white">
            {{'howWork.2.subtitle' | trans}}
          </p>
        </div>
        <div v-show="this.currentIndex == 2">
          <h5 class="text-warning">
            {{'howWork.3.title' | trans}}
          </h5>
          <p class="text-white">
            {{'howWork.3.subtitle' | trans}}
          </p>
        </div>
      </div>


    </div>
    <div class="col-lg-6">
      <div class="position-relative px-5">
        <carousel-3d :autoplay="false" :loop="false" :height="453" :width="270" :border="0" :controls-visible="true" :controls-prev-html="prev" :controls-next-html="next" :controls-width="10" :controls-height="10" @before-slide-change="change">
          <slide :index="0" v-show="currentIndex != 2">
            <img class="how-work-img" src="/images/how_works_attach.jpeg" />
          </slide>
          <slide :index="1">
            <img class="how-work-img" src="/images/how_works_sign.jpeg" />
          </slide>
          <slide :index="2" v-show="currentIndex != 0">
            <img class="how-work-img" src="/images/how_works_download.jpeg" />
          </slide>
        </carousel-3d>


      </div>
    </div>
  </div>


</template>
<script>
  var Lang = require('lang.js');
  import source from "../localization"
  import {
    Carousel3d,
    Slide
  } from 'vue-carousel-3d';
  export default {
    name: 'CarrouselHowWorks',
    props: ["locale"],
    components: {
      Carousel3d,
      Slide
    },
    data: function() {
      return {
        messages: source,
        next: ' <span class="fa-stack text-warning"> <i class="fa fa-circle fa-stack-2x"></i> <i class=" fa fa-angle-right fa-stack-1x text-dark font-weight-bold"></i></span>',
        prev: '<span class="fa-stack text-warning"> <i class="fa fa-circle fa-stack-2x"></i> <i class=" fa fa-angle-left fa-stack-1x text-dark font-weight-bold"></i></span>',
        currentIndex: 0
      }
    },
    created() {
      var lang = new Lang({
        messages: this.messages,
        locale: this.locale,
      });
      console.log(this.locale);

      console.log(lang.get('howWork.title'));
      Vue.filter('trans', (...args) => {
        return lang.get(...args);
      });
    },
    methods: {
      change(e) {
        this.currentIndex = e
        // console.log(e);

      }
    },
  }
</script>
<style>
  .carousel-3d-controls .next {
    font-size: 20px;
    right: 30px;
  }

  .carousel-3d-controls .prev {
    font-size: 20px;
    left: 0px;
  }

  .how-work-img {
    height: 453px;
    width: 270px
  }

  .carousel-3d-slide:not(.current) {
    opacity: 0.3 !important;
  }
</style>
