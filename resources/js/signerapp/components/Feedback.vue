<template>
  <div>
    <b-btn variant="c-white btn-feedback shadow" size="sm" @click="handleFeedbackButton">
      <b>
        {{'feedback.button' | trans}}
      </b>
    </b-btn>
    <b-modal v-model="isShowFeedbackModal" header-class="pb-0" :hide-header-close="true" :no-close-on-backdrop="true" :cancel-title="'feedback.modal.cancelButton' | trans" :ok-title="
    'feedback.modal.okButton' | trans" ok-variant="warning" @hidden="handleHiddenModal" @ok="handleOkButtonModal">
      <template v-slot:modal-title>
        <b>
          {{'feedback.modal.title' | trans}}
        </b>
      </template>
      <p class="text-white">
        {{'feedback.modal.body' | trans}}
      </p>
      <b-form-group class="mb-0" :invalid-feedback="errors.data.messages" :state="errors.state.messages">
        <b-form-textarea class="" id="feedback" v-model="feedback.messages" :placeholder="'feedback.modal.placeholder' | trans" rows="3" :state="errors.state.messages">
        </b-form-textarea>
      </b-form-group>
    </b-modal>

  </div>
</template>
<script>
  import {
    EventBus
  } from "@/signerapp/event.js";
  export default {
    name: 'Feedback',
    data: function() {
      return {
        isShowFeedbackModal: false,
        feedback: {
          messages: ''
        },
        errors: {
          state: {
            messages: null
          },
          data: {
            messages: ''
          }
        }

      }
    },
    created() {},
    methods: {
      handleFeedbackButton() {
        this.isShowFeedbackModal = true
      },
      handleHiddenModal() {
        this.feedback.messages = ''
        this.errors.state.messages = null
        this.errors.data.messages = ''

      },
      handleOkButtonModal(e) {
        e.preventDefault()

        let locale = this.$lang.getLocale()
        axios.post(`inbox/feedback/${locale}`, this.feedback)
          .then((response) => {
            console.log(response.data)
            this.isShowFeedbackModal = false
            EventBus.$emit('showToast', {
              title: this.$filters.trans('feedback.toast.sendFeedback.title'),
              body: this.$filters.trans('feedback.toast.sendFeedback.body'),
              variant: "success",
              visible: true
            })
            this.feedback.messages = ''
          })
          .catch((error) => {
            console.log(error);

            if (typeof error.response.data.errors.messages !== 'undefined') {
              this.errors.state.messages = false
              this.errors.data.messages = error.response.data.errors.messages[0]
            } else {
              this.errors.state.messages = true
            }

          })
      }
    },
  }
</script>
<style>
</style>
