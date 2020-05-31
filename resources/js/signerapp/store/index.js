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
const PARENTPAGE = "PARENTPAGE";
const STEP = "STEP";
const SIGNAUTRE = "SIGNAUTRE";
const ISLOADING = "ISLOADING";
const ISSHOWDRAGGER = "ISSHOWDRAGGER";
const DRAGGERBEHAVIOR = "DRAGGERBEHAVIOR";
const ISSHOWSIGNATUREMODAL = "ISSHOWSIGNATUREMODAL";


export const store = new Vuex.Store({
  state: {
    step: 1,
    isLoading: false,
    isFileUploaded: false,
    isShowDragger: true,
    isShowShowSignatureModal: false,
    dataPdf: {
      raw: null,
      fileName: '',
      src: null,
      pageCount: null,
      currentPage: 1,
      loadedRatio: null
    },
    dragger: {
      width: 75,
      height: 45,
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
    signature: {
      src: null
    }
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

    [SIGNAUTRE](state, n) {
      state.signature.src = n;
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
    [ISSHOWSIGNATUREMODAL](state, n) {
      state.isShowShowSignatureModal = n;
    },
    [DRAGGERBEHAVIOR](state, n) {
      state.draggerBehavior.isDraggable = n.isDraggable;
      state.draggerBehavior.isResizeable = n.isResizeable;
    },

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
    setDragger({
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
    setSignature({
      commit
    }, data) {

      commit(SIGNAUTRE, data);
    },
    setPdfLoadedRatio({
      commit
    }, data) {
      let dataPdf = {
        loadedRatio: data,
      }
      commit(PDFLOADEDRATIO, dataPdf);
    },
    setDraggerBehavior({
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
    setShowSignatureModal({
      commit
    }, data) {
      commit(ISSHOWSIGNATUREMODAL, data);
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
