import axios from 'axios'

const defOpts = {
  endpoint: '',
  method: 'get',
  onSuccess: () => '',
  onError: () => '',
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

  const o = { ...defOpts, ...opts }

  axios({
    method: o.method,
    url: 'http://localhost:8000' + o.endpoint,
    data: o.body,
  })
    .then((res) => {
      console.log('OK', res)
      o.onSuccess({ status: res.status, data: res.data })
    })
    .catch((res) => {
      o.onError({ status: res.response.status, data: res.response.data })
      // console.log('Wrong', res)
    })
  //   let optionalBody =
  //     method.toLowerCase() === 'get' ? {} : { body: JSON.stringify(body) }

  //   fetch(endpoint, { method, ...optionalBody, headers: { ...headers } }).then()
}
