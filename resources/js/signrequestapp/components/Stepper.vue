<template>
  <div class="w-100 px-lg-5 px-0">
    <div class="mb-3">
      <a :href="getHomeUrl">
        <b-img style="height:40px" fluid src="/images/signfinger.svg"></b-img>
      </a>
    </div>
    <b-card v-for="(v,i) in data" :key="i" class="font-weight-bold shadow" :class="[step == i+1 ? 'bg-warning':' bg-c-dark-grey text-white d-none d-lg-block',v.class]" no-body>
      <b-card-body class="py-2">

        <h5 class="mb-0">
          <b>{{v.title}}</b>
        </h5>
      </b-card-body>
    </b-card>
  </div>
</template>
<script>
  import {
    mapState,
    mapActions
  } from 'vuex'
  export default {
    name: 'Stepper',
    // props: ["step"],
    data: function() {
      return {
        data: [{
            title: this.$filters.trans('stepper.1'),
            class: 'mb-3'
          },
          {
            title: this.$filters.trans('stepper.2'),
            class: 'mb-3'
          },
          {
            title: this.$filters.trans('stepper.3'),
            class: 'mb-3'
          },

        ]
      }
    },
    created() {},
    computed: {
      getHomeUrl() {

        return this.$lang.getLocale() == 'id' ? './id' : './'
      },
      ...mapState({
        step: state => state.step,
      })
    },
    methods: {

    },
  }
</script>
<style>
</style>
