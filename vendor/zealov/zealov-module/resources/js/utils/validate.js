
export function isExternal(path) {
  return /^(http?:|https?:|mailto:|tel:)/.test(path)
}


export function validUsername(str) {
  const valid_map = ['admin', 'editor']
  return valid_map.indexOf(str.trim()) >= 0
}
