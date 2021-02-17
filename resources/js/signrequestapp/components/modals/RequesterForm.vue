<template>
  <b-modal id="requesterFormModal" header-class="pb-0" :hide-header-close="true" :no-close-on-backdrop="true" centered ok-variant="warning" @hidden="handleHiddenModal" @ok="submitRequesterData" @cancel="handleCancelClick">
    <template v-slot:modal-title>
      <b>
        {{'requesterFormModal.title' | trans}}
      </b>
    </template>
    <div>
      <b-form-group :state="states.name">
        <b-form-input id="name" class=" " variant="warning" v-model="input.name" :state="states.name" placeholder="Name"></b-form-input>
        <b-form-invalid-feedback v-if="!$v.input.name.minLength">Please input min 6 Char</b-form-invalid-feedback>
        <b-form-invalid-feedback v-if="!$v.input.name.required">Requester name is required</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group :state="states.email">
        <b-form-input id="email" class=" " variant="warning" v-model="input.email" :state="states.email" placeholder="Email"></b-form-input>
        <b-form-invalid-feedback v-if="!$v.input.email.email">Please input valid email format</b-form-invalid-feedback>
        <b-form-invalid-feedback v-if="!$v.input.email.required">Signer email is required</b-form-invalid-feedback>

      </b-form-group>
      <b-form-group :state="states.message">
        <b-form-textarea id="message" v-model="input.messages" placeholder="Type your message here" rows="3" :state="states.messages">

        </b-form-textarea>
        <b-form-invalid-feedback v-if="!$v.input.messages.minLength">Please input min 15 Char</b-form-invalid-feedback>
        <b-form-invalid-feedback v-if="!$v.input.messages.required">Messages is required</b-form-invalid-feedback>
      </b-form-group>

      <!-- to be added due date data input -->

    </div>
    <template v-slot:modal-cancel>
      <i class="fa fa-close"></i>
      {{'requesterFormModal.button.cancel' | trans}}
    </template>
    <template v-slot:modal-ok>
      <i class="fa fa-check"></i>
      {{'requesterFormModal.button.submit' | trans}}
    </template>
  </b-modal>
</template>
<script>
  import {
    mapState,
    mapActions,
    mapMutations
  } from 'vuex'
  import {
    required,
    email,
    minLength
  } from "vuelidate/lib/validators";
  export default {
    name: 'RequesterForm',
    data: function() {
      return {
        input: {
          email: '',
          name: '',
          messages: ""
        },
        errors: {
          email: null,
          name: null,
          messages: null
        },
        states: {
          email: null,
          name: null,
          messages: null
        },
      }
    },
    validations: {
      input: {
        name: {
          required,
          minLength: minLength(6),

        },
        messages: {
          required,
          minLength: minLength(15),

        },
        email: {
          required,
          email
        }
      }
    },
    created() {},
    mounted() {

    },
    computed: {

    },
    watch: {
      // '$v.input.name.minLength': function(newVal, oldVal) {
      //   this.$v.input.name.minLength && this.$v.input.name.required ? this.states.name = true : this.states.name = false
      // },
      // '$v.input.name.required': function(newVal, oldVal) {
      //   this.$v.input.name.minLength && this.$v.input.name.required ? this.states.name = true : this.states.name = false
      // },
      // '$v.input.messages.minLength': function(newVal, oldVal) {
      //   this.$v.input.messages.minLength && this.$v.input.messages.required ? this.states.messages = true : this.states.messages = false
      // },
      // '$v.input.messages.required': function(newVal, oldVal) {
      //   this.$v.input.messages.minLength && this.$v.input.messages.required ? this.states.messages = true : this.states.messages = false
      // },
      // '$v.input.email.email': function(newVal, oldVal) {
      //   this.$v.input.email.email && this.$v.input.email.required ? this.states.email = true : this.states.email = false
      // },
      // '$v.input.email.required': function(newVal, oldVal) {
      //   this.$v.input.email.email && this.$v.input.email.required ? this.states.email = true : this.states.email = false
      // },
    },
    methods: {
      ...mapActions(['setStep', 'setShowModal', 'restart']),
      ...mapMutations(['ADDREQUESTER', 'REMOVESIGNAREA']),
      handleHiddenModal() {
        // this.clearData()
      },
      handleCancelClick() {
        this.REMOVESIGNAREA()
        setTimeout(() => {
          this.clearData()
        }, 100);

      },
      submitRequesterData(e) {

        this.$v.input.$touch();
        this.$v.input.name.minLength && this.$v.input.name.required ? this.states.name = true : this.states.name = false
        this.$v.input.messages.minLength && this.$v.input.messages.required ? this.states.messages = true : this.states.messages = false
        this.$v.input.email.email && this.$v.input.email.required ? this.states.email = true : this.states.email = false
        if (this.$v.input.$error) {

          e.preventDefault()
          return
        }
        this.$bvModal.hide('requesterFormModal')
        this.$bvModal.show('confirmSubmitModal')
        this.ADDREQUESTER(this.input)
      },
      clearData() {
        this.input = {
          email: '',
          name: '',
          messages: ""
        }
        this.errors = {
          email: null,
          name: null,
          messages: null
        }
        this.states = {
          email: null,
          name: null,
          messages: null
        }
      }



    },
  }
</script>
<style>

</style>
