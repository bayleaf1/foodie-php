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
}
export default function fetchApp(opts = {}) {
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
      // console.log('OK', res)
      o.onSuccess({ status: res.status, data: res.data })
    })
    .catch((res) => {
      o.onError({ status: res.response.status, data: res.response.data })
      // console.log('Wrong', res)
    })
    .finally(o.onFinally)
  //   let optionalBody =
  //     method.toLowerCase() === 'get' ? {} : { body: JSON.stringify(body) }

  //   fetch(endpoint, { method, ...optionalBody, headers: { ...headers } }).then()
}
