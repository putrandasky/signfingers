<template>
  <vue-draggable-resizable :class="[srcSignature ?'border-0':'']" v-if="isShown" style="z-index:99;text-align:center;display:table" :w="dragger.width" :h="dragger.height" :x="dragger.left" :y="dragger.top" :min-height="bpValue(40,25)" :min-width="bpValue(80,50)" :max-height="bpValue(120,75)" :max-width="bpValue(240,150)" :resizable="isResizeable" :draggable="isDraggable" @dragging="handleDrag" @resizing="handleResize" :active="true" :prevent-deactivation="true" :parent="true" v-on:resizestop="handleResizeStop" v-on:dragstop="handleResizeStop">
    <div v-if="!srcSignature" class="inner-box" :style="{width:dragger.width+'px',height:dragger.height+'px','font-size':bpValue('16px','10px')}">
      SIGN HERE
      <!-- <p>{{dragger.width}} x {{dragger.height}}</p>
      <p>{{targetProperties.parentWidth}} x {{targetProperties.parentHeight}}</p>
      <p>{{dragger.left}} x {{dragger.top}}</p> -->
    </div>
    <img v-if="srcSignature" :src="srcSignature" :style="{width:dragger.width+'px',height:dragger.height+'px'}">
  </vue-draggable-resizable>
</template>
<script>
  import VueDraggableResizable from 'vue-draggable-resizable'
  import debounce from './package/debounce'
  import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
  import {
    EventBus
  } from "@/signerapp/event.js";
  export default {
    name: 'PreviewDragger',
    props: ["parentPage"],
    components: {
      VueDraggableResizable
    },
    data: function() {
      return {
        isResizeable: true,
        isDraggable: true,
        isShown: true,
        srcSignature: null,
        dragger: {
          width: 75,
          height: 45,
          top: 0,
          left: 0,
          elementTop: 0,
          elementLeft: 0,
        },
        targetProperties: {

          parentWidth: this.parentPage.width,
          parentHeight: this.parentPage.height,
        }
      }
    },
    created() {
      this.dragger.elementTop = this.dragger.top + this.dragger.height / 2;
      this.dragger.elementLeft = this.dragger.left + this.dragger.width / 2;
      this.dragger.width = this.bpValue(80, 50)
      this.dragger.height = this.bpValue(40, 25)
      this.handleResizeStop()
      EventBus.$on('onSaveSigature', data => {
        this.srcSignature = data;
        this.isResizeable = false
        this.isDraggable = false
      })
      EventBus.$on('onCancelModalSignature', data => {
          this.srcSignature = null
          this.isResizeable = true
          this.isDraggable = true
        }),

        EventBus.$on('onResetClick', (data) => {
          console.log('test');
          this.dragger.width = this.bpValue(80, 50)
          this.dragger.height = this.bpValue(40, 25)
          this.dragger.top = 0
          this.dragger.left = 0
          this.isShown = false
          setTimeout(() => {
            this.isShown = true

          }, 1);
        })
    },
    mounted() {
      this.$nextTick(function() {
        // window.addEventListener('resize', this.refreshInstance);
        // window.addEventListener('resize', this.updateDimension);


      })

    },
    watch: {


      'parentPage.width': debounce(function(newVal, oldVal) {
        this.targetProperties.parentWidth = newVal

        if (oldVal == 0) {
          return
        }
        let oldDraggerLeft = this.dragger.left
        let oldDraggerWidth = this.dragger.width

        this.dragger.left = parseFloat(newVal / oldVal * oldDraggerLeft)
        this.dragger.width = parseFloat(newVal / oldVal * oldDraggerWidth)
        this.dragger.elementLeft = this.dragger.left + this.dragger.width / 2;

        console.table({
          'oldLeft': oldDraggerLeft,
          'newLeft': this.dragger.left,
          'oldWidth': oldDraggerWidth,
          'newWidth': this.dragger.width,
          'oldParentWidth': oldVal,
          'newParentWidth': newVal,
        })
        this.refreshInstance()

      }, 100),
      'parentPage.height': debounce(function(newVal, oldVal) {
        this.targetProperties.parentHeight = newVal
        if (oldVal == 0) {
          return
        }
        let oldDraggerTop = this.dragger.top
        let oldDraggerHeight = this.dragger.height

        this.dragger.top = parseFloat(newVal / oldVal * oldDraggerTop)
        this.dragger.height = parseFloat(newVal / oldVal * oldDraggerHeight)
        this.dragger.elementTop = this.dragger.top + this.dragger.height / 2;

        console.table({
          'oldTop': oldDraggerTop,
          'newTop': this.dragger.top,
          'oldHeight': oldDraggerHeight,
          'newHeight': this.dragger.height,
          'oldParentHeight': oldVal,
          'newParentHeight': newVal,
        })
        this.refreshInstance()

      }, 100)
    },
    methods: {

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
        this.dragger.top = y;
        this.dragger.left = x;
        this.dragger.elementTop = y + this.dragger.height / 2;
        this.dragger.elementLeft = x + this.dragger.width / 2;
      },
      handleResize(x, y, width, height) {
        // if (width < height) {
        //   this.isResizeable = false
        //   return
        // }
        this.dragger.width = width;
        this.dragger.height = height;
        this.dragger.top = y;
        this.dragger.left = x;
        this.dragger.elementTop = y + height / 2;
        this.dragger.elementLeft = x + width / 2;
      },
      handleResizeStop() {
        this.$emit('onResizeStop', this.dragger)
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
    border: 3px dashed #000;
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
