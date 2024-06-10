let label = 'admin-jwt'
const JwtStorage = {
  exists() {
    return !!localStorage.getItem(label)
  },
  save(token) {
    localStorage.setItem(label, token)
  },
  remove() {
    localStorage.removeItem(label)
  },
}

export default JwtStorage
