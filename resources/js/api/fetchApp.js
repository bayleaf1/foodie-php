import axios from 'axios'
import JwtStorage from '../auth'

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
    url: 'http://localhost:8000' + o.endpoint,
    data: o.body,
    headers: o.headers,
  })
    .then((res) => {
      o.onSuccess({ status: res.status, data: res.data })
    })
    .catch((res) => {
      let { status, data } = res.response
      o.onError({ status, data })
      if (status === 401) {
        JwtStorage.remove()
        window.location.reload()
      }
      if (status === 422) {
        Object.entries(data.errors).forEach(([key, [msg]]) => {
          o.errorModelFor422.value[key] = msg
        })
      }
    })
    .finally(o.onFinally)
}
