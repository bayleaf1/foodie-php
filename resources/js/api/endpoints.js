const endpoints = {
  ordersTable: ({ page, search, searchableField, sorting }) => {
    return `/api/orders/table?page=${page}&search=${search}&searchableField=${searchableField}&sorting=${sorting}`
  },
}

export default endpoints
