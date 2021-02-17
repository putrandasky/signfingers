<template>
  <b-container fluid class="h-100  position-relative">
    <b-row class="d-flex justify-content-center py-5">

      <a href="/">
        <b-img style="height:40px" fluid src="/images/signfinger.svg"></b-img>
      </a>
    </b-row>

    <b-row class="d-flex justify-content-center align-items-center " v-if="isDataLoaded">

      <b-col xl="4" md="6" sm="10" cols="12" class="mt-5" v-if="!isAuthorized">

        <b-alert show variant="danger">
          <h4 class="alert-heading"><b> {{unathorizedStatus}}</b></h4>
          {{unathorizedMessage}}.
        </b-alert>
      </b-col>
      <!-- <b-col xl="4" md="6" sm="10" cols="12" v-if="!isAuthorized">

      </b-col> -->
      <b-col xl="4" md="6" sm="10" cols="12" class="" v-if="isAuthorized">
        <b-card class="signature-pad border-0" no-body>
          <template #header>
            <b>
              {{'signaturePad.title' | trans}}
            </b>
          </template>
          <b-card-body>
            <div class="text-center text-white">

              <h5 class="mb-0">
                <strong>
                  {{fileName}}
                </strong>
              </h5>
              <small>page {{page}}</small>
            </div>
            <small class="text-white mb-3">
              Requested by {{requesterName}} ({{requesterEmail}})
            </small>
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
                <b-btn-group>
                  <b-btn v-for="(v,i) in dataColorPen" :key="i" :pressed="v.color == padOptions.penColor" :variant=" v.color == 'black' ? 'outline-light':'outline-'+v.color" size="sm" @click="handleChangeColorButton(v.color)">{{v.title}}</b-btn>
                </b-btn-group>
              </div>
            </div>
            <small class="text-white">
              {{'signaturePad.tips' | trans}}
            </small>
          </b-card-body>

          <b-card-footer footer-class="text-right">
            <b-btn variant="warning" @click="saveSignature">{{'signaturePad.submit' | trans}}</b-btn>
          </b-card-footer>
        </b-card>
      </b-col>
    </b-row>
    <!-- <table class="h-100 mx-auto" v-if="isDataLoaded">
      <tbody>
        <tr>
          <td class=" align-middle">

          </td>
        </tr>
      </tbody>
    </table> -->
    <ending-modal></ending-modal>
    <custom-toast></custom-toast>
    <b-overlay :show="isLoading " rounded="sm" no-wrap variant="dark" spinner-variant="warning">
    </b-overlay>
  </b-container>
</template>
<script>
  import debounce from './package/debounce'
  import EndingModal from './modals/Ending'
  import CustomToast from './custom/CustomToast'

  import {
    EventBus
  } from "@/signrequestrespondapp/event.js";
  export default {
    name: 'App',
    // props: ["draggerData"],
    components: {
      EndingModal,
      CustomToast
    },
    data: function() {
      return {
        // isModalShow: false,
        isAuthorized: false,
        unathorizedMessage: '',
        unathorizedStatus: '',
        step: 0,
        isLoading: true,
        isDataLoaded: false,
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
        },
        signAreas: [],
        signatures: [],
        fileName: '',
        page: null,
        requesterName: '',
        requesterEmail: '',
        signerToken: ''

      }
    },
    created() {

    },
    mounted() {
      this.getData()
      this.$nextTick(function() {
        window.addEventListener('resize', this.refreshInstance);
      })
    },
    watch: {

    },
    computed: {

    },
    methods: {

      refreshInstance: debounce(function() {
        if (this.showPad) {
          this.padAdjustment()
          this.refreshInstanceSignPad()


        }
      }, 100),

      getData() {
        var pageURL = window.location.href;
        this.signerToken = pageURL.substr(pageURL.lastIndexOf('/') + 1);
        axios.get(`/sign-request/token/${this.signerToken}`)
          .then((response) => {
            console.log(response.data.signer_data)
            let signerData = response.data.signer_data
            this.isAuthorized = true
            this.signAreas = signerData.sign_areas
            this.requesterName = signerData.requester.name
            this.requesterEmail = signerData.requester.email
            this.fileName = signerData.requester.filename
            this.page = signerData.sign_areas[this.step].target_page
            this.handleShowModal()
            this.isDataLoaded = true
            setTimeout(() => {
              this.isLoading = false
            }, 100);
          })
          .catch((error) => {
            console.log(error);
            this.unathorizedMessage = error.response.data.message;
            this.unathorizedStatus = error.response.data.status;
            this.isDataLoaded = true;
            this.authorized = false;
            setTimeout(() => {
              this.isLoading = false
            }, 100);
          })
      },
      handleShowModal() {

        let self = this
        let penColor = this.padOptions.penColor || 'black'
        setTimeout(() => {
          this.padAdjustment()
          this.padOptions.penColor = penColor
          this.showPad = true
        }, 1);
      },
      handleCancelModal() {

        this.tempDataSignature = null
        this.setSignature(null)
      },
      saveSignature(e) {
        this.isLoading = true
        console.log('saved');
        const {
          isEmpty,
          data
        } = this.$refs.signaturePad.saveSignature()

        if (isEmpty) {
          EventBus.$emit('showToast', {
            title: "ERROR",
            body: "You are not drawing any signature",
            variant: "danger",
            visible: true
          })
          this.isLoading = false
          e.preventDefault()
          return
        }

        // this.setSignature(data)
        var form = new FormData();

        form.append("itemSignData", data);

        axios.post(`/sign-request/sign-file/${this.signerToken}`, form, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then((response) => {
            console.log(response.data)
            this.$bvModal.show('endModal')
            this.isLoading = false
            this.isDataLoaded = false
          })
          .catch((error) => {
            console.log(error);
          })
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
      setSignature(data) {
        this.signatures[this.step] = data
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
          (parentPadWidth / (this.signAreas[this.step].width / this.signAreas[this.step].height)).toString() + "px"
      },
      handleHiddenModal() {
        this.showPad = false
        console.log('test');


      }
    },
  }
</script>
<style lang="scss">
  @import '../../../sass/app.scss';
</style>
