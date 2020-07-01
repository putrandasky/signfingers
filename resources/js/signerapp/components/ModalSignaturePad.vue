<template>
  <b-modal v-model="isShowShowSignatureModal" modal-class="signature-pad-modal" :hide-header-close="true" :no-close-on-backdrop="true" centered ok-variant="warning" @hidden="handleHiddenModal" @show="handleShowModal" @ok="saveSignature" @cancel="handleCancelModal">
    <template v-slot:modal-title>
      <b>
        {{'signaturePad.title' | trans}}
      </b>
    </template>
    <div id="parentPad" class="position-relative" :style="{height:padHeight,'background-color':'#fff'}" ref="parentPad">

      <VueSignaturePad v-if="showPad" style="border:1px solid grey" :width="padWidth" :height="padHeight" :options="padOptions" ref="signaturePad" id="signaturePad" />
    </div>

    <div class="mt-2">
      <b-btn variant="secondary" size="sm" @click="refreshInstanceSignPad">
        {{'signaturePad.clearButton' | trans}}
      </b-btn>
      <b-btn variant="secondary" size="sm" @click="handleUndoButton">
        {{'signaturePad.undoButton' | trans}}
      </b-btn>
      <div class="d-inline-block">
        <!-- <div class="text-white text-center">
          <small>
            Color
          </small>
        </div> -->
        <b-btn-group>
          <b-btn v-for="(v,i) in dataColorPen" :key="i" :pressed="v.color == padOptions.penColor" :variant=" v.color == 'black' ? 'outline-light':'outline-'+v.color" size="sm" @click="handleChangeColorButton(v.color)">{{v.title}}</b-btn>
        </b-btn-group>
      </div>
    </div>
    <small class="text-white">
      {{'signaturePad.tips' | trans}}
    </small>
    <template v-slot:modal-ok>
      <i class="fa fa-search"></i>
      {{'signaturePad.previewButton' | trans}}
    </template>
    <template v-slot:modal-cancel>
      <i class="fa fa-close"></i>
      {{'signaturePad.cancelButton' | trans}}
    </template>
  </b-modal>
</template>
<script>
  import debounce from './package/debounce'
  import {
    mapState,
    mapActions
  } from 'vuex'
  import {
    EventBus
  } from "@/signerapp/event.js";
  export default {
    name: 'ModalSignaturePad',
    // props: ["draggerData"],
    components: {},
    data: function() {
      return {
        // isModalShow: false,
        showPad: false,
        tempDataSignature: null,
        padWidth: "100%",
        padHeight: "1px",
        dataColorPen: [{
            color: 'black',
            title: this.$filters.trans('signaturePad.blackColorPenButton')
          },
          {
            color: 'blue',
            title: this.$filters.trans('signaturePad.blueColorPenButton')
          },
          {
            color: 'green',
            title: this.$filters.trans('signaturePad.greenColorPenButton')
          }
        ],
        padOptions: {
          backgroundColor: 'rgba(255,255,255,0)',
          dotSize: (0.5 + 2.5) / 2,
          minWidth: 0.5,
          maxWidth: 2.5,
        }
      }
    },
    created() {

    },
    mounted() {
      this.$nextTick(function() {
        window.addEventListener('resize', this.refreshInstance);
      })
    },
    watch: {
      'isFileSigned': function(newVal, oldVal) {
        if (newVal) {
          this.tempDataSignature = null
        }
      }
    },
    computed: {
      isShowShowSignatureModal: {
        get() {
          return this.$store.state.isShowShowSignatureModal
        },
        set(value) {
          this.setShowSignatureModal(value)
        }
      },
      ...mapState({
        dragger: state => state.dragger,
        fileName: state => state.dataPdf.fileName,
        pageCount: state => state.dataPdf.pageCount,
        currentPage: state => state.dataPdf.currentPage,
        isFileSigned: state => state.dataPdf.isFileSigned,
      })
    },
    methods: {
      ...mapActions(['setDataPdf', 'setParentPage', 'setStep', 'setFileUploaded', 'setLoading', 'setPdfTotalPage', 'setPdfCurrentPage', 'setDragger', 'setDraggerBehavior', 'setShowSignatureModal', 'setSignature']),
      refreshInstance: debounce(function() {
        if (this.showPad) {
          let self = this
          this.tempDataSignature = this.$refs.signaturePad.toData()
          this.padAdjustment()
          this.refreshInstanceSignPad()
          setTimeout(() => {
            self.$refs.signaturePad.fromData(self.tempDataSignature)

          }, 2);

        }
      }, 100),
      handleShowModal() {

        let self = this
        let penColor = this.padOptions.penColor || 'black'
        setTimeout(() => {
          this.padAdjustment()
          this.padOptions.penColor = penColor
          this.showPad = true
          if (self.tempDataSignature) {
            setTimeout(() => {
              self.$refs.signaturePad.fromData(self.tempDataSignature)
            }, 1);
          }
        }, 1);
      },
      handleCancelModal() {
        let behavior = {
          isResizeable: true,
          isDraggable: true
        }
        this.setDraggerBehavior(behavior)
        this.tempDataSignature = null
        this.setSignature(null)
      },
      saveSignature(e) {

        const {
          isEmpty,
          data
        } = this.$refs.signaturePad.saveSignature()

        if (isEmpty) {
          // this.$bvToast.show('empty-signpad-toast')
          EventBus.$emit('showToast', {
            title: "ERROR",
            body: "You are not drawing any signature",
            variant: "danger",
            visible: true
          })
          e.preventDefault()
          return
        }

        this.tempDataSignature = this.$refs.signaturePad.toData()
        let behavior = {
          isResizeable: false,
          isDraggable: false
        }
        this.setDraggerBehavior(behavior)
        this.setSignature(data)
        this.setStep(4)
      },
      refreshInstanceSignPad() {
        this.showPad = false
        this.$refs.signaturePad.clearSignature()
        this.tempDataSignature = null
        this.setSignature(null)
        this.$nextTick(() => {

          this.showPad = true
        });
      },
      handleUndoButton() {
        this.$refs.signaturePad.undoSignature()
        this.tempDataSignature = this.$refs.signaturePad.toData()
        this.$nextTick(function() {
          this.$refs.signaturePad.fromData(this.tempDataSignature)

        })

      },
      handleChangeColorButton(color) {
        if (this.padOptions.penColor == color) {
          return
        }
        this.tempDataSignature = this.$refs.signaturePad.toData()
        console.log("handleChangeColorButton -> dataSignature", this.tempDataSignature)

        this.padOptions = {
          penColor: color
        };
        let self = this
        this.$refs.signaturePad.clearSignature()
        this.$nextTick(function() {
          this.$refs.signaturePad.fromData(this.tempDataSignature)

        })

      },
      padAdjustment() {
        let parentPadWidth = this.$refs.parentPad.offsetWidth;
        let defaultSignMinWidth = 0.5
        let defaultSignMaxWidth = 2.5
        let baseWidthSignPad = 460
        this.padOptions = {
          minWidth: parentPadWidth / baseWidthSignPad * defaultSignMinWidth,
          maxWidth: parentPadWidth / baseWidthSignPad * defaultSignMaxWidth,
          dotSize: (this.padOptions.minWidth + this.padOptions.maxWidth) / 2
        };

        this.padWidth = parentPadWidth.toString() + "px";
        this.padHeight =
          (parentPadWidth / (this.dragger.width / this.dragger.height)).toString() + "px"
      },
      handleHiddenModal() {
        this.showPad = false
        console.log('test');


      }
    },
  }
</script>
<style>

</style>
