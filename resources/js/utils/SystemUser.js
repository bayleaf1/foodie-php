const STORAGE_LABEL = 'systemUser'

export class SystemUserNull {
  constructor(...args) {
    this.d = { name: '', email: '', role: '' }
    this.postConstructor(...args)
  }
  postConstructor(data) {}
  name() {
    return this.d.name || ''
  }
  email() {
    return this.d.email
  }
  toString() {
    return this.d.toString()
  }
  role() {
    return this.d.role
  }
  canAccess(resourceName) {
    return false
  }
  saveToLocalStorage() {}
}

export class SystemUser extends SystemUserNull {
  postConstructor(data) {
    this.d = data
  }
  canAccess(resourceName) {
    if (resourceName === 'system-users-page') {
      //   console.log('ROLE', this.role())
      return this.role() === 'root' //TODO CAHNGE to root
    }
    return false
  }

  saveToLocalStorage() {
    localStorage.setItem(STORAGE_LABEL, JSON.stringify(this.d))
  }

  static createFromLocalStorage() {
    try {
      let data = localStorage.getItem(STORAGE_LABEL)
      if (data) return new SystemUser(JSON.parse(data))
    } catch (e) {
      localStorage.removeItem(STORAGE_LABEL)
      return new SystemUserNull()
    }
  }
}
