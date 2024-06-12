import dayjs from 'dayjs'

const Clock = {
  formatOrderCreation(date) {
    return dayjs(date).format('hh:mm DD/MM/YYYY')
  },
  formatProductCreation(date) {
    return dayjs(date).format('DD/MM/YYYY')
  },
}

export default Clock
