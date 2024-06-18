const label = 'orderList'
const defList = { orders: [] }

const saveList = (c) => localStorage.setItem(label, JSON.stringify(c))
const initializeListIfMissing = () => {
  if (!localStorage.getItem(label)) saveList(defList)
}
const retrieve = () => {
  initializeListIfMissing()
  return JSON.parse(localStorage.getItem(label))
}

const OrderList = {
  addOrderId(id) {
    let list = retrieve()
    let order = list.orders.find((o) => o.id === id)
    if (order) return
    list.orders.push({ id })
    saveList(list)
  },

  getIdList() {
    return retrieve().orders.map((o) => o.id)
  },

  empty() {
    let list = retrieve()
    list.orders = []
    saveList(list)
  },
}

export default OrderList
