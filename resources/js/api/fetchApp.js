import axios from 'axios'
import JwtStorage from '../auth'
import Notificator from '../utils/Notificator'
import config from '../constants/config'

const defOpts = {
  endpoint: '',
  method: 'get',
  onSuccess: () => '',
  onError: () => '',
  onFinally: () => '',
  body: {},
  headers: {},
  errorModelFor422: { value: {} },
}
export default function fetchApp(opts = defOpts) {
  // const {
  //   endpoint = '',
  //   method = 'get',
  //   onSuccess = () => '',
  //   onError = () => '',
  //   body = {},
  //   headers: {},
  // } = opts

  const o = {
    ...defOpts,
    ...opts,
    headers: {
      authorization: `Bearer ${JwtStorage.retrieve()}`,
      ...defOpts.headers,
      ...(opts.headers || {}),
    },
  }

  axios({
    method: o.method,
    url: config.APP_URL + o.endpoint,
    data: o.body,
    headers: o.headers,
  })
    .then((res) => {
      o.onSuccess({ status: res.status, data: res.data })
    })
    .catch((res) => {
      // console.log('HERE', res)
      let data = res?.response?.data || {}
      let status = res?.response?.status || 500
      // console.log('ERROR: ', data.message, res)
      o.onError({ status, data })
      if (status === 401) {
        JwtStorage.remove()
        window.location.reload()
        Notificator.pushError('Authorization token is missing or invalid')
      } else if (status === 422) {
        Object.entries(data.errors).forEach(([key, [msg]]) => {
          o.errorModelFor422.value[key] = msg
        })
      } else {
        Notificator.pushError(data.message || res.message)
      }
    })
    .finally(o.onFinally)
}

export function fetchAppForSwr(method = 'get', body = {}) {
  return (url) =>
    new Promise((res, rej) => {
      fetchApp({
        endpoint: url,
        method,
        body,
        onSuccess: ({ data }) => {
          res(data)
        },
        onError: ({ data }) => {
          rej(data)
        },
      })
    })
}
