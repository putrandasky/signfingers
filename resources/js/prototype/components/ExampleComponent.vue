<template>
  <div>
    <div style="position:relative;width:50%;float:left">
      <input type="file" ref="fileInput" name="fileInput" id="fileInput" v-on:change="handleFileUpload()" />
      {{currentPage}} / {{pageCount}}
      <button style="padding:3px;background-color:green" @click="sendData2">Post</button>
      <div style="position:relative" ref="parent" @click="handleClickParent">
        <!-- <div
          v-if="loadedRatio > 0 && loadedRatio < 1"
          style="background-color: green; color: white; text-align: center"
          :style="{ width: loadedRatio * 100 + '%' }"
        >{{ Math.floor(loadedRatio * 100) }}%</div> -->
        <vue-draggable-resizable style="z-index:99;text-align:center;display:table" v-if="showDrager" :w="width" :h="height" :x="left" :y="top" :minHeight="30" :minWidth="50" @dragging="onDrag" @resizing="onResize" :parent="true" v-on:resizestop="onResizeStop" v-on:dragstop="onResizeStop">
          <div style="display:table-cell;vertical-align:middle;background-color:yellow;padding:3px" :style="{width:width+'px',height:height+'px'}">
            SIGN HERE
          </div>
          <!-- <img  style="display:table-cell;vertical-align:middle" :src="srcSignature"
                    :style="{width:width+'px',height:height+'px'}"
                    > -->
        </vue-draggable-resizable>

        <!-- <VueDragResize
          v-if="showDrager"
          :parentLimitation="true"
          style="z-index:99;text-align:center;display:table"
          :isActive="true"
          :w="width"
          :h="height"
          :x="left"
          :y="top"
          v-on:resizing="resize"
          v-on:dragging="resize"
          v-on:resizestop="resizeStop"
          v-on:dragstop="resizeStop"
          :parentW="parentWidth"
          :parentH="parentHeight"
          :minh="20"
          :minw="20"
          @clicked="handleClickDrager"
        >
          <div style="display:table-cell;vertical-align:middle">
            <h3>.</h3>
            <p>{{width}} x {{height}}</p>
            <p>{{parentWidth}} x {{parentHeight}}</p>
          <p>{{left}} x {{top}}</p>
          </div>
        </VueDragResize> -->
        <!-- <Moveable
      class="moveable"
      v-bind="moveable"
      @drag="handleDrag"
      @resize="handleResize"
      @scale="handleScale"
    >
      <span>Vue Moveable</span>
        </Moveable>-->

        <!-- <div style="width:20px;height:20px;background-color:red;position:absolute;z-index:99"
        :style="{top:elementTop+'px',left:elementLeft+'px'}"></div>-->
        <pdf style="border: 1px solid black" :src="src" @num-pages="pageCount = $event" @page-loaded="currentPage = $event" @progress="loadedRatio = $event"></pdf>
      </div>
    </div>
    <div style="position:relative;width:50%;float:left" ref="parentPad">
      <button style="background-color:blue; padding;5px" @click="saveSignature">Save</button>
      <VueSignaturePad v-if="showPad" style="border:1px solid grey" :width="padWidth" :height="padHeight" :options="padOptions" ref="signaturePad" />
    </div>
  </div>
</template>
<script>
  import pdf from "vue-pdf";
  import Moveable from "vue-moveable";
  import VueDragResize from "vue-drag-resize";
  import FileSaver from "file-saver";
  import VueSignaturePad from "vue-signature-pad";
  import VueDraggableResizable from 'vue-draggable-resizable'
  import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
  export default {
    name: "ExampleComponent",
    components: {
      pdf,
      Moveable,
      VueDragResize,
      VueDraggableResizable
    },
    data: function() {
      return {
        showPad: false,
        padWidth: 0,
        padHeight: 0,
        currentPage: 0,
        pageCount: 0,
        showDrager: false,
        width: 100,
        height: 100,
        top: 0,
        left: 0,
        isShowModal: false,
        loadedRatio: 0,
        rotate: 0,
        src: "",
        signData: null,
        page: 1,
        numPages: undefined,
        isShowModal: false,
        filename: "",
        moveable: {
          draggable: true,
          throttleDrag: 0,
          resizable: false,
          throttleResize: 1,
          keepRatio: false,
          scalable: true,
          throttleScale: 0,
          rotatable: true,
          throttleRotate: 0,
          pinchable: true, // ["draggable", "resizable", "scalable", "rotatable"]
          origin: false
        },
        elementTop: 0,
        elementLeft: 0,
        parentWidth: 0,
        parentHeight: 0,
        fileUrl: null,
        srcSignature: null,
        padOptions: {
          penColor: 'blue'
        }
      };
    },
    mounted: function() {
      //   window.addEventListener('resize', this.handleResize())
    },
    beforeDestroy: function() {
      //   window.removeEventListener('resize', this.handleResize())
    },
    created() {
      // this.show();
    },
    mounted() {
      // this.$watch(
      //     () => {
      //         return this.$refs.parent.offsetWidth
      //     },
      //     (val) => {
      //         console.log(val)
      //     }
      // )
    },
    watch: {},
    methods: {
      handleLoaded() {
        console.log("loaded");
      },
      saveSignature() {
        const {
          isEmpty,
          data
        } = this.$refs.signaturePad.saveSignature()
        this.signData = data
        this.srcSignature = data
        console.log(isEmpty);
        console.log(data);
      },
      handleFileUpload(e) {
        console.log(this.$refs.fileInput.files[0]);
        // var reader = new FileReader()
        // reader.onload = (e) => this.fileUrl = e.target.result
        // console.log(reader.readAsDataURL(this.$refs.fileInput.files[0]))
        let objectUrl = URL.createObjectURL(this.$refs.fileInput.files[0]);
        var loadingTask = pdf.createLoadingTask(objectUrl);
        this.src = loadingTask;
        loadingTask.onProgress = ({
          loaded,
          total
        }) => {
          console.log(total);
          if (loaded == total) {
            setTimeout(() => {
              this.showDrager = true;
              let parentPadWidth = this.$refs.parentPad.offsetWidth;
              this.padWidth = parentPadWidth.toString() + "px";
              console.log(this.padWidth / (this.width / this.height));

              this.padHeight =
                (parentPadWidth / (this.width / this.height)).toString() + "px";
              console.log({
                "parent width pad": this.padWidth,
                "parent height pad": this.padHeight
              });

              this.showPad = true;
            }, 100);
          }
        };
        // this.src.then(pdf => {
        //     console.log(pdf);

        //     this.numPages = pdf.numPages;
        //     setTimeout(() => {
        //         this.showDrager = true
        //     }, 1);

        // });
      },
      sendData2() {
        let self = this;
        let input = {
          elementTop: this.elementTop,
          elementLeft: this.elementLeft,
          parentWidth: this.parentWidth,
          parentHeight: this.parentHeight,
          width: this.width,
          height: this.height
        };
        let itemInput = JSON.stringify(input);
        var form = new FormData();
        form.append("itemInput", itemInput);
        form.append("itemSignData", this.signData);
        form.append("itemFile", this.$refs.fileInput.files[0]);
        axios
          .post("/generate", form, {
            responseType: "blob",
            headers: {
              "Content-Type": "multipart/form-data"
              // 'Content-Type': 'multipart/form-data; charset=utf-8; boundary="'+ Math.random().toString().substr(2)+'"'
            }
          })
          .then(response => {
            let ContentDisposition = response.headers["content-disposition"];
            let splitedContentDisposition = ContentDisposition.split('"');
            FileSaver.saveAs(response.data, splitedContentDisposition[1]);
            // console.log('success');
            console.log(response.data);
          })
          .catch(error => {
            console.log(error);
            // console.log('fail');
          });
      },
      sendData() {
        let input = {
          elementTop: this.elementTop,
          elementLeft: this.elementLeft,
          parentWidth: this.parentWidth,
          parentHeight: this.parentHeight,
          width: this.width,
          height: this.height
        };
        axios
          .post(`/generate`, input, {
            responseType: "blob"
          })
          .then(response => {
            let ContentDisposition = response.headers["content-disposition"];
            let splitedContentDisposition = ContentDisposition.split('"');
            FileSaver.saveAs(response.data, splitedContentDisposition[1]);
          })
          .catch(error => {
            console.log(error);
          });
      },
      resizeStop() {
        let parentPadWidth = this.$refs.parentPad.offsetWidth;
        this.padWidth = parentPadWidth.toString() + "px";
        this.padHeight =
          (parentPadWidth / (this.width / this.height)).toString() + "px";
        this.showPad = true
      },
      onResizeStop() {

        let parentPadWidth = this.$refs.parentPad.offsetWidth;
        this.padWidth = parentPadWidth.toString() + "px";
        this.padHeight =
          (parentPadWidth / (this.width / this.height)).toString() + "px";

        this.showPad = true
      },
      resize(newRect) {
        this.width = newRect.width;
        this.height = newRect.height;
        this.top = newRect.top;
        this.left = newRect.left;
        this.elementTop = newRect.top + this.height / 2;
        this.elementLeft = newRect.left + this.width / 2;
        this.parentWidth = this.$refs.parent.offsetWidth;
        this.parentHeight = this.$refs.parent.offsetHeight;
        this.showPad = false

      },
      onResize(x, y, width, height) {
        this.width = width;
        this.height = height;
        this.top = y;
        this.left = x;
        this.elementTop = this.top + this.height / 2;
        this.elementLeft = this.left + this.width / 2;
        this.parentWidth = this.$refs.parent.offsetWidth;
        this.parentHeight = this.$refs.parent.offsetHeight;
        this.showPad = false
      },
      handleResize(e) {
        console.log(e);
      },
      onDrag(x, y) {

        this.top = y;
        this.left = x;
        this.elementTop = this.top + this.height / 2;
        this.elementLeft = this.left + this.width / 2;
        this.parentWidth = this.$refs.parent.offsetWidth;
        this.parentHeight = this.$refs.parent.offsetHeight;
        this.showPad = false
      },
      handleClickDrager(e) {
        // console.log(e);

        return
      },
      handleClickParent(e) {
        return

        //   console.log(e);
        //   console.log({
        //     "Offset Width": this.$refs.parent.offsetWidth,
        //     "Offset Height": this.$refs.parent.offsetHeight,
        //     clientX: e.clientX,
        //     clientY: e.clientY
        //   });
        this.top = e.offsetY - this.height / 2;
        this.left = e.offsetX - this.width / 2;
      },

      show() {
        var loadingTask = pdf.createLoadingTask("test2.pdf");
        this.src = loadingTask;
        this.src.then(pdf => {
          this.numPages = pdf.numPages;
        });
      }
    }
  };
</script>
<style>
  .moveable {
    z-index: 99;
    position: absolute;
  }
</style>
