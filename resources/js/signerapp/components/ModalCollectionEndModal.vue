<template>
  <b-modal hide-footer id="endModal" header-class="pb-0" :hide-header-close="true" :no-close-on-backdrop="true" centered ok-variant="warning" @hidden="handleHiddenModal">
    <template v-slot:modal-title>
      <b>
        {{'endModal.title' | trans}}
      </b>
    </template>
    <div class="mb-3">
      <p class="text-white">
        {{'endModal.body' | trans}}
      </p>
      <b-btn variant="warning" block @click="handleOkEndModal">
        <b>
          {{'endModal.button' | trans}}
        </b>
      </b-btn>
    </div>
    <div>
      <p class="text-white">
        {{'endModal.share.body' | trans}}
      </p>
      <ShareSocialCollection />
    </div>
    <div v-if="!storage.review.digitalSignature">
      <p class="text-white">
        {{'endModal.review.body' | trans}}
      </p>
      <b-form-group class="mb-0" :invalid-feedback="errors.messages.data" :state="errors.messages.state">
        <b-form-textarea class="" id="review" v-model="review.messages" placeholder="Type your review here" rows="3" :state="errors.messages.state">
        </b-form-textarea>
      </b-form-group>
      <b-form-group :invalid-feedback="errors.rating.data" :state="errors.rating.state">
        <b-input-group>
          <b-input-group-prepend>
            <b-input-group-text class="bg-c-dark text-c-white border-0 pl-0">
              Rating
            </b-input-group-text>
          </b-input-group-prepend>
          <b-form-rating id="rating" class=" bg-c-dark border-0" variant="warning" v-model="review.rating"></b-form-rating>
        </b-input-group>
      </b-form-group>
      <!-- <label class="text-c-white" for="rating">Rating</label> -->
      <b-btn variant="success" block @click="sendReview">
        <b>
          {{'endModal.review.button' | trans}}
        </b>
      </b-btn>
    </div>
  </b-modal>
</template>
<script>
  import {
    mapState,
    mapActions
  } from 'vuex'
  import {
    EventBus
  } from "@/signerapp/event.js";
  import ShareSocialCollection from './ModalCollectionEndModalShare'
  export default {
    name: 'ModalCollectionEndModal',
    components: {
      ShareSocialCollection,
    },
    data: function() {
      return {
        review: {

          rating: null,
          messages: ""
        },
        errors: {
          messages: {
            state: null,
            data: ''
          },
          rating: {
            state: null,
            data: ''
          },
        },
        storage: {
          review: {
            digitalSignature: false,
          }
        }
      }
    },
    created() {},
    mounted() {
      if (localStorage.getItem('data')) {
        try {
          this.storage = JSON.parse(localStorage.getItem('data'));
        } catch (e) {
          localStorage.removeItem('data');
        }
      }
    },
    computed: {
      isShowEndModal: {
        get() {
          return this.$store.state.isShowEndModal
        },
        set(value) {
          this.setShowModal({
            name: 'endModal',
            value: value
          })
        }
      },
    },
    methods: {
      ...mapActions(['setShowModal', 'restart']),
      handleOkEndModal() {
        this.$bvModal.hide('endModal')
        this.restart()
      },
      handleHiddenModal() {

        this.review.rating = null
        this.review.messages = ''
        this.errors.messages.state = null
        this.errors.messages.data = ''
        this.errors.rating.state = null
        this.errors.rating.data = ''
      },
      sendReview() {
        let locale = this.$lang.getLocale()


        axios.post(`inbox/review/${locale}`, this.review)
          .then((response) => {
            EventBus.$emit('showToast', {
              title: this.$filters.trans('endModal.toast.sendReview.title'),
              body: this.$filters.trans('endModal.toast.sendReview.body'),
              variant: "success",
              visible: true
            })
            this.storage.review.digitalSignature = true
            localStorage.data = JSON.stringify(this.storage)
          })
          .catch((error) => {
            let dataErrors = error.response.data.errors
            if (typeof dataErrors.messages !== 'undefined') {
              this.errors.messages.state = false
              this.errors.messages.data = dataErrors.messages[0]
            } else {
              this.errors.messages.state = true
            }
            if (typeof dataErrors.rating !== 'undefined') {
              this.errors.rating.state = false
              this.errors.rating.data = dataErrors.rating[0]
            } else {
              this.errors.rating.state = true

            }

          })
      }

    },
  }
</script>
<style>

</style>
