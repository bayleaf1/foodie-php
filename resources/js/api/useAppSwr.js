import { watch } from 'vue'
import { fetchAppForSwr } from './fetchApp'
import useSWRV from 'swrv'

const defOpts = {
  body: {},
  method: 'get',
  reactiveEndpoint: '',
  onSuccess: ({ data }) => '',
  onError: ({ data }) => '',
  loadingModel: { value: '' },
}

export default function useAppSwr(options = defOpts) {
  let opts = {
    ...defOpts,
    ...options,
  }
  watch(
    opts.reactiveEndpoint,
    () => {
      opts.loadingModel.value = true
    },
    { immediate: true }
  )
  const { data, error, mutate } = useSWRV(
    opts.reactiveEndpoint,
    fetchAppForSwr(opts.method, opts.body),
    {
      revalidateOnFocus: true,
    }
  )

  watch(data, (d) => {
    if (d) {
      opts.loadingModel.value = false
      opts.onSuccess({ data: d })
    } else {
      opts.loadingModel.value = true
    }
  })
  watch(error, (e) => {
    opts.loadingModel.value = false
    if (e) opts.onError({ data: e })
  })

  return { refresh: () => mutate() }
}
