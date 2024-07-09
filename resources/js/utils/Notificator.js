import { useToast } from 'vue-toast-notification'

const $toast = useToast()

const Notificator = {
  pushSuccess(msg = 'Success', opts = {}) {
    return $toast.success(msg, { ...opts })
  },
  pushError(msg = 'Error') {
    return $toast.error(msg)
  },
}

export default Notificator
