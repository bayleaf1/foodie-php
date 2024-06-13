const endpoints = {
  ordersTable: ({ page, search, searchableField, sorting }) => {
    return `/api/orders/table?page=${page}&search=${search}&searchableField=${searchableField}&sorting=${sorting}`
  },
  productImage: (imageName) => 'http://localhost:8000/resources/' + imageName,
  products: '/api/products',
  resources: '/api/resources',
}

export default endpoints
