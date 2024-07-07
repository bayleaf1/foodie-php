import StringMask from 'string-mask'

const phoneFormat = '(###) ###-####'
const phoneFormatter = new StringMask(phoneFormat)

export function renderPhoneNumber(number) {
  return phoneFormatter.apply(number)
}
