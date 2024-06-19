import dayjs from 'dayjs'

const Clock = {
  formatOrderCreation(date) {
    return dayjs(date).format('hh:mm DD/MM/YYYY')
  },
  formatProductCreation(date) {
    return dayjs(date).format('DD/MM/YYYY')
  },
  formatOrderUpdate(date) {
    return dayjs(date).format('A hh:mm DD/MM/YYYY')
  },
  formatSystemUserCreation(date) {
    return dayjs(date).format('DD/MM/YYYY')
  },
  isGt(date1, date2) {
    return dayjs(date1).isAfter(date2)
  },
}

export default Clock
