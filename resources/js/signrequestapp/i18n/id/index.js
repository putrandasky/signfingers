import feedback from './feedback'
import stepper from './stepper'
import fileChooser from './previewFileChooser'
import endModal from './endModal'
import signerFormModal from './signerFormModal'
import confirmSubmitModal from './confirmSubmitModal'
import requesterFormModal from './requesterFormModal'
import controlAddSigner from './previewFileControlAddSigner'
import controlPage from './previewFileControlPage'
import controlTarget from './previewFileControlTarget'
import sharingSocial from './sharingSocial'

export default {
  ...feedback,
  ...stepper,
  ...fileChooser,
  ...endModal,
  ...requesterFormModal,
  ...controlAddSigner,
  ...signerFormModal,
  ...confirmSubmitModal,
  ...controlPage,
  ...controlTarget,
  ...sharingSocial


}
