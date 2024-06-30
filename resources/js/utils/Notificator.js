import { useToast } from 'vue-toast-notification'

const $toast = useToast()

const Notificator = {
  pushSuccess(msg = 'Success') {
    return $toast.success(msg)
  },
  pushError(msg = 'Error') {
    return $toast.error(msg)
  },
}

export default Notificator
