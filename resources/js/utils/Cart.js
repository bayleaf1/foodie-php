const label = 'cart'
const defCart = { products: [] }

const saveCart = (c) => localStorage.setItem(label, JSON.stringify(c))
const initializeCartIfMissing = () => {
  if (!localStorage.getItem(label)) saveCart(defCart)
}
const Cart = {
  size() {
    return this.retrieve().products.length
  },
  retrieve() {
    initializeCartIfMissing()
    return JSON.parse(localStorage.getItem(label))
  },
  addProduct(id, quantity) {
    let cart = this.retrieve()
    let product = cart.products.find((p) => p.id === id)
    if (product) product.quantity += quantity
    else cart.products.push({ id, quantity })
    saveCart(cart)
  },
  removeProduct() {
    let cart = this.retrieve()
    cart.products = cart.products.filter((p) => p.id != id)
    saveCart(cart)
  },
  clear() {},
}

export default Cart
