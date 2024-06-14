export default function createErrorsStateForForm(formState, defErrorMsg = '') {
  return {
    ...Object.fromEntries(Object.keys(formState).map((k) => [k, defErrorMsg])),
    resetFor(field) {
      this[field] = ''
    },
  }
}
