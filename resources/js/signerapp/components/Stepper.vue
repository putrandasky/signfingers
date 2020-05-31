<template>
  <div class="w-100 px-lg-5 px-0">
    <b-card v-for="(v,i) in data" :key="i" class="font-weight-bold rounded-pill" :class="[step == i+1 ? 'bg-warning':' bg-c-dark-grey text-white d-none d-lg-block',v.class]" no-body>
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
            title: '1. Choose your file',
            class: 'mb-3'
          },
          {
            title: '2. Select page',
            class: 'mb-3'
          },
          {
            title: '3. Define area & sign',
            class: 'mb-3'
          },
          {
            title: '4. Preview & download',
            class: 'mb-3'
          },
        ]
      }
    },
    created() {},
    computed: mapState({
      step: state => state.step,
    }),
    methods: {},
  }
</script>
<style>
</style>
