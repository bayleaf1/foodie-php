const endpoints = {
  ordersTable: ({ page, search, searchableField, sorting }) => {
    return `/api/orders/table?page=${page}&search=${search}&searchableField=${searchableField}&sorting=${sorting}`
  },
  productsTable: (opts = {}) => {
    let params = {
      page: 1,
      search: '',
      searchableField: 'id',
      sorting: 'desc',
      pageSize: 5,
      ...opts,
    }

    let query = Object.entries(params).reduce(
      (acc, [key, value]) => `${acc}${key}=${value}&`,
      ''
    )

    return `/api/products/table?${query}`
  },
  productImage: (imageName) => 'http://localhost:8000/resources/' + imageName,
  product: (id) => '/api/products/' + id,
  products: '/api/products',
  resources: '/api/resources',
}

export default endpoints
