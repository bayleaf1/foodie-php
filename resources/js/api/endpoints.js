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
  cart: '/api/products/cart',
  orders: '/api/orders',
  order: (id) => '/api/orders/' + id,
  ordersOfGuest: '/api/orders/guest',
  ordersTable: (opts = {}) => `/api/orders/table?${createTableQuery(opts)}`,
  changeOrderStatus: (id, action) => `/api/orders/${action}/${id}`,

  products: '/api/products',
  productsMenu: '/api/products/menu',
  productShowcase: (id) => '/api/products/showcase/' + id,
  product: (id) => '/api/products/' + id,
  productsTable: (opts = {}) => `/api/products/table?${createTableQuery(opts)}`,
  productImage: (imageName) => 'http://localhost:8000/resources/' + imageName,
  resources: '/api/resources',
  //
  systemUserMe: '/api/system-users/me',
  systemUserProfile: (id) => '/api/system-users/profile/' + id,
  systemUsersTable: (opts = {}) =>
    `/api/system-users/table?${createTableQuery(opts)}`,
  systemUserRegistration: `/api/auth/register/system-user`,
}

export default endpoints
