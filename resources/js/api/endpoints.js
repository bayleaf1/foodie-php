function createTableQuery(opts = {}) {
  let params = {
    page: 1,
    search: '',
    searchableField: 'id',
    sorting: 'desc',
    pageSize: 5,
    ...opts,
  }
  return Object.entries(params).reduce(
    (acc, [key, value]) => `${acc}${key}=${value}&`,
    ''
  )
}
const endpoints = {
  ordersTable: (opts = {}) => `/api/orders/table?${createTableQuery(opts)}`,
  productsTable: (opts = {}) => `/api/products/table?${createTableQuery(opts)}`,
  productImage: (imageName) => 'http://localhost:8000/resources/' + imageName,
  product: (id) => '/api/products/' + id,
  products: '/api/products',
  resources: '/api/resources',
}

export default endpoints
