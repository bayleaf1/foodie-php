import { ref } from 'vue'

export const createStateRef = (partials = {}) =>
  ref({
    pageSize: 5,
    page: 1,
    searchableField: 'id',
    search: '',
    sorting: 'desc',
    ...partials,
  })

export const createTableRef = (partials = {}) =>
  ref({
    totalRows: 0,
    rows: [],
    pagesCount: 0,
    ...partials,
  })
