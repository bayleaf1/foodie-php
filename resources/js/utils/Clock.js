import dayjs from 'dayjs'

const Clock = {
  formatOrderCreation(date) {
    return dayjs(date).format('hh:mm DD/MM/YYYY')
  },
}

export default Clock
