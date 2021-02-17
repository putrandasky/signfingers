<template>
  <div class="d-flex flex-wrap mb-2">
    <ShareNetwork network="facebook" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :style="{backgroundColor: '#1877f2'}">
      <i class="fa fa-facebook"></i>
      <span>Facebook</span>
    </ShareNetwork>
    <ShareNetwork network="whatsapp" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :style="{backgroundColor: '#25d366'}">
      <i class="fa fa-whatsapp"></i>
      <span>Whatsapp</span>
    </ShareNetwork>
    <ShareNetwork network="telegram" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :style="{backgroundColor: '#0088cc'}">
      <i class="fa fa-telegram"></i>
      <span>Telegram</span>
    </ShareNetwork>
    <ShareNetwork network="twitter" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :style="{backgroundColor: '#1da1f2'}">
      <i class="fa fa-twitter"></i>
      <span>Twitter</span>
    </ShareNetwork>
    <ShareNetwork network="linkedin" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :style="{backgroundColor: '#007bb5'}">
      <i class="fa fa-linkedin"></i>
      <span>Linkedin</span>
    </ShareNetwork>
    <ShareNetwork network="email" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :style="{backgroundColor: '#E8EDDF'}">
      <i class="fa fa-envelope text-c-dark"></i>
      <span class="text-c-dark">Email</span>
    </ShareNetwork>

  </div>
</template>
<script>
  export default {
    name: 'ModalCollectionEndModalSh',
    data: function() {
      return {
        sharing: {
          url: this.$filters.trans('socialNetwork.url'),
          title: this.$filters.trans('socialNetwork.title'),
          description: this.$filters.trans('socialNetwork.description'),
          quote: this.$filters.trans('socialNetwork.quote'),
          hashtags: this.$filters.trans('socialNetwork.hashtags')

        }
      }
    },
    created() {},
    computed: {},
    methods: {

    },
  }
</script>
<style>

</style>
