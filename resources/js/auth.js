let label = 'admin-jwt'
const JwtStorage = {
  exists() {
    return !!this.retrieve()
  },
  save(token) {
    localStorage.setItem(label, token)
  },
  remove() {
    localStorage.removeItem(label)
  },
  retrieve(){
    return localStorage.getItem(label) || ''
  },
}

export default JwtStorage
