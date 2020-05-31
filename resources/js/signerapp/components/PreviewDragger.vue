<template>
  <vue-draggable-resizable :class="[signature.src ?'border-0':'']" v-if="isShowDragger" style="z-index:99;text-align:center;display:table" :w="dragger.width" :h="dragger.height" :x="dragger.left" :y="dragger.top" :min-height="bpValue(40,25)" :min-width="bpValue(80,50)" :max-height="bpValue(120,75)" :max-width="bpValue(240,150)" :resizable="draggerBehavior.isResizeable" :draggable="draggerBehavior.isDraggable" @dragging="handleDrag" @resizing="handleResize" :active="true" :prevent-deactivation="true" :parent="true" v-on:resizestop="handleResizeStop" v-on:dragstop="handleResizeStop">
    <div v-if="!signature.src" class="inner-box" :style="{width:dragger.width+'px',height:dragger.height+'px','font-size':bpValue('16px','10px')}">
      SIGN HERE
      <!-- <p>{{dragger.width}} x {{dragger.height}}</p>
      <p>{{targetProperties.parentWidth}} x {{targetProperties.parentHeight}}</p>
      <p>{{dragger.left}} x {{dragger.top}}</p> -->
    </div>
    <img v-if="signature.src" :src="signature.src" :style="{width:dragger.width+'px',height:dragger.height+'px'}">
  </vue-draggable-resizable>
</template>
<script>
  import VueDraggableResizable from 'vue-draggable-resizable'
  import debounce from './package/debounce'
  import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
  import {
    mapState,
    mapActions
  } from 'vuex'
  import {
    EventBus
  } from "@/signerapp/event.js";
  export default {
    name: 'PreviewDragger',
    // props: ["parentPage"],
    components: {
      VueDraggableResizable
    },
    data: function() {
      return {
        // isResizeable: true,
        // isDraggable: true,
        // isShown: true,
        // srcSignature: null,
        // dragger: {
        //   width: 75,
        //   height: 45,
        //   top: 0,
        //   left: 0,
        //   elementTop: 0,
        //   elementLeft: 0,
        // },
        // targetProperties: {

        //   parentWidth: this.parentPage.width,
        //   parentHeight: this.parentPage.height,
        // }
      }
    },
    created() {
      // this.dragger.elementTop = this.dragger.top + this.dragger.height / 2;
      // this.dragger.elementLeft = this.dragger.left + this.dragger.width / 2;
      // this.dragger.width = this.bpValue(80, 50)
      // this.dragger.height = this.bpValue(40, 25)
      this.handleResizeStop()
      // EventBus.$on('onSaveSigature', data => {
      //   this.srcSignature = data;
      //   this.isResizeable = false
      //   this.isDraggable = false
      // })
      // EventBus.$on('onCancelModalSignature', data => {
      //   this.srcSignature = null
      //   this.isResizeable = true
      //   this.isDraggable = true
      // })

      // EventBus.$on('onResetClick', (data) => {
      //   console.log('test');
      //   this.dragger.width = this.bpValue(80, 50)
      //   this.dragger.height = this.bpValue(40, 25)
      //   this.dragger.top = 0
      //   this.dragger.left = 0
      //   this.isShown = false
      //   setTimeout(() => {
      //     this.isShown = true

      //   }, 1);
      // })
    },
    mounted() {
      this.$nextTick(function() {
        // window.addEventListener('resize', this.refreshInstance);
        // window.addEventListener('resize', this.updateDimension);


      })

    },
    computed: mapState({
      parentPage: state => state.parentPage,
      dragger: state => state.dragger,
      signature: state => state.signature,
      isShowDragger: state => state.isShowDragger,
      draggerBehavior: state => state.draggerBehavior,
    }),
    watch: {


      'parentPage.width': debounce(function(newVal, oldVal) {
        // this.targetProperties.parentWidth = newVal

        if (oldVal == 0) {
          return
        }
        let oldDraggerLeft = this.dragger.left
        let oldDraggerWidth = this.dragger.width

        let draggerleft = parseFloat(newVal / oldVal * oldDraggerLeft)
        let draggerwidth = parseFloat(newVal / oldVal * oldDraggerWidth)
        let draggerelementLeft = draggerleft + draggerwidth / 2;
        console.log('parentpagewidth');

        // this.$store.commit('DRAGGER', {
        //   left: draggerleft,
        //   width: draggerwidth,
        //   elementLeft: draggerelementLeft,
        // })
        let dragger = {
          width: draggerwidth,
          height: this.dragger.height,
          top: this.dragger.top,
          left: draggerleft,
          elementTop: this.dragger.elementTop,
          elementLeft: draggerelementLeft,
        }
        this.setDragger(dragger)
        console.table({
          'oldLeft': oldDraggerLeft,
          'newLeft': draggerleft,
          'oldWidth': oldDraggerWidth,
          'newWidth': draggerwidth,
          'oldParentWidth': oldVal,
          'newParentWidth': newVal,
        })
        this.refreshDraggerInstance()
        // this.refreshInstance()

      }, 100),
      'parentPage.height': debounce(function(newVal, oldVal) {
        // this.targetProperties.parentHeight = newVal
        if (oldVal == 0) {
          return
        }
        let oldDraggerTop = this.dragger.top
        let oldDraggerHeight = this.dragger.height

        let draggertop = parseFloat(newVal / oldVal * oldDraggerTop)
        let draggerheight = parseFloat(newVal / oldVal * oldDraggerHeight)
        let draggerelementTop = draggertop + draggerheight / 2;
        // this.$store.commit('DRAGGER', {
        //   top: draggertop,
        //   height: draggerheight,
        //   elementTop: draggerelementTop,
        // })
        let dragger = {
          width: this.dragger.width,
          height: draggerheight,
          top: draggertop,
          left: this.dragger.left,
          elementTop: this.dragger.elementLeft,
          elementLeft: draggerelementTop
        }
        this.setDragger(dragger)
        console.table({
          'oldTop': oldDraggerTop,
          'newTop': draggertop,
          'oldHeight': oldDraggerHeight,
          'newHeight': draggerheight,
          'oldParentHeight': oldVal,
          'newParentHeight': newVal,
        })
        // this.refreshInstance()
        this.refreshDraggerInstance()

      }, 100)
    },
    methods: {
      ...mapActions(['setDragger', 'refreshDraggerInstance', 'setStep']),
      bpValue(lgUpValue, lgDownValue) {
        return ['lg', 'xl'].includes(this.$mq) ? lgUpValue : lgDownValue
      },
      refreshInstance() {
        this.isShown = false
        setTimeout(() => {
          this.isShown = true
          console.log('refreshInstance')

        }, 1);
      },
      updateDimension() {
        let oldDraggerLeft = this.dragger.left
        let oldParentWidth = this.targetProperties.parentWidth

        this.dragger.left = this.parentPage.width / oldParentWidth * oldDraggerLeft
        console.log("updateDimension -> this.dragger.left ", this.dragger.left)
      },
      handleDrag(x, y) {
        // this.dragger.top = y;
        // this.dragger.left = x;
        // this.dragger.elementTop = y + this.dragger.height / 2;
        // this.dragger.elementLeft = x + this.dragger.width / 2;

        let dragger = {
          width: this.dragger.width,
          height: this.dragger.height,
          top: y,
          left: x,
          elementTop: y + this.dragger.height / 2,
          elementLeft: x + this.dragger.width / 2,
        }
        this.setDragger(dragger)
      },
      handleResize(x, y, width, height) {
        // if (width < height) {
        //   this.isResizeable = false
        //   return
        // }
        // this.dragger.width = width;
        // this.dragger.height = height;
        // this.dragger.top = y;
        // this.dragger.left = x;
        // this.dragger.elementTop = y + height / 2;
        // this.dragger.elementLeft = x + width / 2;
        let dragger = {
          width: width,
          height: height,
          top: y,
          left: x,
          elementTop: y + height / 2,
          elementLeft: x + width / 2,
        }
        this.setDragger(dragger)
      },
      handleResizeStop() {
        // this.$emit('onResizeStop', this.dragger)
        // let parentPadWidth = this.$refs.parentPad.offsetWidth;
        // this.padWidth = parentPadWidth.toString() + "px";
        // this.padHeight =
        //   (parentPadWidth / (this.width / this.height)).toString() + "px";

        // this.showPad = true
      },
    },
    beforeDestroy() {
      // window.removeEventListener('resize', this.refreshInstance);
    },

  }
</script>
<style scoped>
  .vdr {
    border: 2px dashed #000;
  }


  .vdr>.inner-box {
    display: flex;
    justify-content: center;
    align-items: center;
    vertical-align: middle;
    background-color: rgba(255, 255, 0, 0.5);
    padding: 3px;
    cursor: move;
  }
</style>>
