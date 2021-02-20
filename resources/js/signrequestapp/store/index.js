import Vue from 'vue';
import Vuex from 'vuex';
// import Cookies from "js-cookie";
// import router from './router/index';

Vue.use(Vuex);

const ISFILEUPLOADED = "ISFILEUPLOADED";
const DATAPDF = "DATAPDF";
const PDFTOTALPAGE = "PDFTOTALPAGE";
const PDFCURRENTPAGE = "PDFCURRENTPAGE";
const PDFLOADEDRATIO = "PDFLOADEDRATIO";
const DRAGGER = "DRAGGER";
const DRAGGERV = "DRAGGERV";
const DRAGGERH = "DRAGGERH";
const PARENTPAGE = "PARENTPAGE";
const STEP = "STEP";
const ISLOADING = "ISLOADING";
const ISSHOWDRAGGER = "ISSHOWDRAGGER";
const DRAGGERBEHAVIOR = "DRAGGERBEHAVIOR";
const ISSHOWENDMODAL = "ISSHOWENDMODAL";
const ADDSIGNER = "ADDSIGNER"
const REMOVESIGNER = "REMOVESIGNER"
const ADDREQUESTER = "ADDREQUESTER"
const ADDSIGNAREA = "ADDSIGNAREA"
const REMOVESIGNAREA = "REMOVESIGNAREA"
const RESETSIGNER = "RESETSIGNER"
const RESETREQUESTER = "RESETREQUESTER"
const SIGNERTOKEN = "SIGNERTOKEN"

export const store = new Vuex.Store({
  state: {
    step: 1,
    isLoading: false,
    isFileUploaded: false,
    isShowDragger: true,
    isShowEndModal: false,
    dataPdf: {
      raw: null,
      fileName: '',
      src: null,
      pageCount: null,
      currentPage: 0,
      loadedRatio: null
    },
    dragger: {
      width: 1,
      height: 1,
      top: 0,
      left: 0,
      elementTop: 0,
      elementLeft: 0,
    },
    draggerBehavior: {
      isResizeable: true,
      isDraggable: true,
    },
    parentPage: {
      height: 0,
      width: 0
    },
    signer: [],
    requester: {},
    signerToken: '',

  },
  mutations: {

    [DRAGGER](state, n) {
      state.dragger.width = n.width
      state.dragger.height = n.height
      state.dragger.top = n.top
      state.dragger.left = n.left
      state.dragger.elementTop = n.elementTop
      state.dragger.elementLeft = n.elementLeft
    },
    [DRAGGERH](state, n) {
      state.dragger.width = n.width
      state.dragger.left = n.left
      state.dragger.elementLeft = n.elementLeft
    },
    [DRAGGERV](state, n) {
      state.dragger.height = n.height
      state.dragger.top = n.top
      state.dragger.elementTop = n.elementTop
    },
    [PARENTPAGE](state, n) {
      state.parentPage.width = n.width
      state.parentPage.height = n.height
    },
    [DATAPDF](state, n) {
      state.dataPdf.raw = n.raw;
      state.dataPdf.fileName = n.fileName;
      state.dataPdf.src = n.src;

    },
    [PDFTOTALPAGE](state, n) {
      state.dataPdf.pageCount = n.pageCount;
    },
    [PDFCURRENTPAGE](state, n) {

      state.dataPdf.currentPage = n.currentPage;
    },
    [PDFLOADEDRATIO](state, n) {
      state.dataPdf.loadedRatio = n.loadedRatio
    },

    [ISLOADING](state, n) {
      state.isLoading = n;
    },
    [ISFILEUPLOADED](state, n) {
      state.isFileUploaded = n;
    },
    [STEP](state, n) {
      state.step = n;
    },
    [ISSHOWDRAGGER](state, n) {
      state.isShowDragger = n;
    },
    [ISSHOWENDMODAL](state, n) {
      state.isShowEndModal = n;
    },
    [DRAGGERBEHAVIOR](state, n) {
      state.draggerBehavior.isDraggable = n.isDraggable;
      state.draggerBehavior.isResizeable = n.isResizeable;
    },
    [ADDSIGNER](state, n) {
      state.signer.push(n)
    },
    [REMOVESIGNER](state, n) {
      let totalSigner = state.signer.length
      if (totalSigner > 0) {
        state.signer.splice(totalSigner - 1, 1)

      }

    },
    [RESETSIGNER](state, n) {
      state.signer = []
    },
    [RESETREQUESTER](state, n) {
      state.requester = {}
    },

    [ADDREQUESTER](state, n) {
      state.requester = n
    },
    [SIGNERTOKEN](state, n) {
      state.signerToken = n
    },
    [ADDSIGNAREA](state) {
      let totalSigner = state.signer.length
      let areaData = state.dragger
      areaData.targetPage = state.dataPdf.currentPage
      areaData.parentWidth = state.parentPage.width
      areaData.parentHeight = state.parentPage.height
      // state.signer[lastSigner - 1].area = state.dragger
      state.signer[totalSigner - 1].area.push(areaData)
    },
    [REMOVESIGNAREA](state) {
      let totalSigner = state.signer.length
      let totalSignerSignArea = state.signer[totalSigner - 1].area.length
      state.signer[totalSigner - 1].area.splice(totalSignerSignArea - 1, 1)
    }

  },
  actions: {
    setLoading({
      commit
    }, isLoading) {
      commit(ISLOADING, isLoading)
    },
    setFileUploaded({
      commit
    }, isFileUploaded) {
      commit(ISFILEUPLOADED, isFileUploaded)
    },
    setStep({
      commit
    }, step) {
      commit(STEP, step)
    },
    setParentPage({
      commit
    }, data) {
      let parentPage = {
        width: data.width,
        height: data.height
      }
      commit(PARENTPAGE, parentPage);
    },
    setCurrentSignArea({
      commit
    }, data) {
      let dragger = {
        width: data.width,
        height: data.height,
        top: data.top,
        left: data.left,
        elementTop: data.elementTop,
        elementLeft: data.elementLeft
      }
      commit(DRAGGER, dragger);
    },
    setCurrentSignAreaH({
      commit
    }, data) {
      let dragger = {
        width: data.width,
        left: data.left,
        elementLeft: data.elementLeft
      }
      commit(DRAGGERH, dragger);
    },
    setCurrentSignAreaV({
      commit
    }, data) {
      let dragger = {
        height: data.height,
        top: data.top,
        elementTop: data.elementTop,
      }
      commit(DRAGGERV, dragger);
    },
    setDataPdf({
      commit
    }, data) {
      let dataPdf = {
        raw: data.raw,
        fileName: data.fileName,
        src: data.src,

      }
      commit(DATAPDF, dataPdf);
    },
    setPdfTotalPage({
      commit
    }, data) {
      let dataPdf = {
        pageCount: data,
      }
      commit(PDFTOTALPAGE, dataPdf);
    },
    setPdfCurrentPage({
      commit
    }, data) {
      let dataPdf = {
        currentPage: data,
      }
      commit(PDFCURRENTPAGE, dataPdf);
    },

    setPdfLoadedRatio({
      commit
    }, data) {
      let dataPdf = {
        loadedRatio: data,
      }
      commit(PDFLOADEDRATIO, dataPdf);
    },
    setCurrentSignAreaBehavior({
      commit
    }, data) {
      let behavior = {
        isResizeable: data.isResizeable,
        isDraggable: data.isDraggable,
      }
      commit(DRAGGERBEHAVIOR, behavior);
    },
    setShowDragger({
      commit
    }, data) {
      commit(ISSHOWDRAGGER, data);
    },
    setShowModal({
      commit
    }, data) {
      if (data.name == 'endModal') {
        commit(ISSHOWENDMODAL, data.value);
      }
    },
    restart({
      commit
    }) {
      let dragger = {
        width: 75,
        height: 45,
        top: 0,
        left: 0,
        elementTop: 0,
        elementLeft: 0,
      }
      let dataPdf = {
        raw: null,
        fileName: '',
        src: null,

      }
      let behavior = {
        isResizeable: true,
        isDraggable: true,
      }
      let dataPageCount = {
        pageCount: null,
      }
      let dataCurrentPage = {
        currentPage: 1,
      }
      let parentPage = {
        height: 0,
        width: 0
      }
      let dataLoadedRatio = {
        loadedRatio: null
      }
      commit(STEP, 1)
      commit(ISFILEUPLOADED, false)

      commit(PDFLOADEDRATIO, dataLoadedRatio);
      commit(PARENTPAGE, parentPage);
      commit(PDFCURRENTPAGE, dataCurrentPage);
      commit(PDFTOTALPAGE, dataPageCount);
      commit(DRAGGERBEHAVIOR, behavior);
      commit(DRAGGER, dragger);

      commit(DATAPDF, dataPdf);
      commit(RESETREQUESTER);
      commit(RESETSIGNER);
    },
    refreshDraggerInstance({
      commit
    }) {
      commit(ISSHOWDRAGGER, false);
      setTimeout(() => {
        commit(ISSHOWDRAGGER, true);
      }, 1);
    },
  },
  getters: {

  }
});
