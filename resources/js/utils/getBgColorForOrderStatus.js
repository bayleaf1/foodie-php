import { OrderStatusType } from './enums.js'
export default function getBgColorForOrderStatus(status) {
  return (
    {
      [OrderStatusType.CREATED]: 'bg-red-500',
      [OrderStatusType.CONFIRMED]: 'bg-blue',
      [OrderStatusType.FINISHED]: 'bg-green',
      [OrderStatusType.CANCELED]: 'bg-slate-300',
    }[status] || ''
  )
}
