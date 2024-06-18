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
    console.log('DAADAD', data)
    this.d = data
  }
  canAccess(resourceName) {
    if (resourceName === 'system-users-page') {
      //   console.log('ROLE', this.role())
      return this.role() === 'manager' //TODO CAHNGE to root
    }
    return false
  }

  saveToLocalStorage() {
    localStorage.setItem(STORAGE_LABEL, JSON.stringify(this.d))
  }

  static createFromLocalStorage() {
    let data = localStorage.getItem(STORAGE_LABEL)
    // console.log("SOME DATA", data);
    if (data) return new SystemUser(JSON.parse(data))
    return new SystemUserNull()
  }
}
