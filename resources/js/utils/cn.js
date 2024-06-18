import clsx from 'clsx'
import { twMerge } from 'tailwind-merge'

function cn(...classes) {
  return twMerge(clsx(...classes))
}

export default cn
