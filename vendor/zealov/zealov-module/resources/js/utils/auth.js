import Cookies from 'js-cookie'

const TokenKey = 'vue_admin_zealov_token'
const LoginType = 'vue_admin_zealov_login_type'

export function getToken() {
    return Cookies.get(TokenKey)
}

export function setToken(token,expires=7200) {
    return Cookies.set(TokenKey, token,{ expires: expires })
}

export function removeToken() {
    return Cookies.remove(TokenKey)
}

export function setLoginType(type) {
    return Cookies.set(LoginType, type)
}

export function getLoginType() {
    return Cookies.get(LoginType)
}

export function removeLoginType() {
    return Cookies.remove(LoginType)
}
