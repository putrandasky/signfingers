<template>
  <vue-draggable-resizable :class="[signature.src ?'border-0':'']" v-if="isShowDragger" style="z-index:99;text-align:center;display:table" drag-handle=".inner-box" :w="dragger.width" :h="dragger.height" :x="dragger.left" :y="dragger.top" :min-height="minHeight" :min-width="minWidth" :max-height="maxHeight" :max-width="maxWidth" :resizable="draggerBehavior.isResizeable" :draggable="draggerBehavior.isDraggable" @dragging="handleDrag" @resizing="handleResize" :active="true" :prevent-deactivation="true" :parent="true" v-on:resizestop="handleResizeStop" v-on:dragstop="handleResizeStop">
    <div v-if="!signature.src" class="inner-box" :style="{width:dragger.width+'px',height:dragger.height+'px','font-size':bpValue('16px','12px')}">
      Sign Here
      <!-- <p>{{dragger.width}} x {{dragger.height}}</p>
      <p>{{dragger.elementLeft}} x {{dragger.elementTop}}</p>
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
        show: true
      }
    },
    created() {


      this.handleResizeStop()

    },
    mounted() {


      this.$nextTick(function() {
        if (!this.signature.src) {
          let dragger = {
            width: this.parentPage.width * 0.3,
            height: this.parentPage.width * 0.3 * 0.5,
            top: 0,
            left: 0,
            elementTop: 0 + this.parentPage.width * 0.3 * 0.5 / 2,
            elementLeft: 0 + this.parentPage.width * 0.3 / 2,
          }
          this.setDragger(dragger)
          console.log('nextic sign src');

          // this.refreshDraggerInstance()
        }
      })

    },
    computed: {
      minWidth() {
        return this.parentPage.width * 0.1
      },
      minHeight() {
        return this.parentPage.width * 0.1 * 0.5
      },
      maxWidth() {
        return this.parentPage.width * 0.3
      },
      maxHeight() {
        return this.parentPage.width * 0.3 * 0.5
      },
      ...mapState({
        parentPage: state => state.parentPage,
        dragger: state => state.dragger,
        signature: state => state.signature,
        isShowDragger: state => state.isShowDragger,
        draggerBehavior: state => state.draggerBehavior,
      })
    },
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

        let dragger = {
          width: draggerwidth,
          left: draggerleft,
          elementLeft: draggerelementLeft,
        }
        this.setDraggerH(dragger)

        this.refreshDraggerInstance()

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

        let dragger = {
          height: draggerheight,
          top: draggertop,
          elementTop: draggerelementTop
        }
        this.setDraggerV(dragger)

        this.refreshDraggerInstance()

      }, 100)
    },
    methods: {
      ...mapActions(['setDragger', 'setDraggerV', 'setDraggerH', 'refreshDraggerInstance', 'setStep']),
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

      },
    },
    beforeDestroy() {},

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
