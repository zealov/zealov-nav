import {
    getInfo,
    login,
    logout
} from '../../api/user'

export const state = {
    token: getToken(),
    name: '',
    nickName: '',
    avatar: '',
    introduction: '',
    roles: [],
    roles_data: [],
    accessedRoutes: [],
    accessedRoute: {},
    unreadNotificationCount: 0,
    role: {},
    perimissionsData: [],
    isToken: true
}
import {
    getToken,
    setToken,
    removeToken,
    setLoginType,
    removeLoginType
} from '../../utils/auth'
import {getPermissions} from '../..//utils/index'
import {resetRouter} from '~/router'

export const mutations = {
    SET_TOKEN: (state, token) => {
        state.token = token
    },
    SET_INTRODUCTION: (state, introduction) => {
        state.introduction = introduction
    },
    SET_NAME: (state, name) => {
        state.name = name
    },
    SET_NICKNAME: (state, name) => {
        state.nickName = name
    },
    SET_ISTOKEN: (state, isToken) => {
        state.isToken = isToken
    },
    SET_AVATAR: (state, avatar) => {
        state.avatar = avatar
    },
    SET_ROLES: (state, roles) => {
        state.roles = roles
    },
    SET_ROLE: (state, role) => {
        state.role = role
    },
    SET_ROLESDATA: (state, data) => {
        state.roles_data = data
    },
    SET_ACCESSEDROUTES: (state, accessedRoutes) => {
        state.accessedRoutes = accessedRoutes
    },
    SET_ACCESSEDROUTE: (state, accessedRoute) => {
        state.accessedRoute = accessedRoute
        state.perimissionsData = getPermissions(accessedRoute)
    },
    SET_UNREADNOTIFICATIONCOUNT: (state, unreadNotificationCount) => {
        state.unreadNotificationCount = unreadNotificationCount
    }
}
// getters
export const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null,
    role: state => state.role,
    roles: state => state.roles,
    nickName: state => state.nickName,
    isToken: state => state.isToken
}

export const actions = {
    // user login
    login({commit}, userInfo) {
        // const { name, password } = userInfo
        return new Promise((resolve, reject) => {
            login(userInfo)
                .then((response) => {
                    localStorage.setItem('a', JSON.stringify(response))
                    const {data} = response
                    commit('SET_TOKEN', data.access_token)
                    let seconds = data.expires_in ? data.expires_in : 7200
                    let expires = new Date(new Date() * 1 + seconds * 1000)
                    setToken(data.access_token, expires)
                    setLoginType('')
                    resolve()
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
    // get user info
    getInfo({commit, hasToken}) {
        return new Promise((resolve, reject) => {
            getInfo()
                .then((response) => {
                    const {data} = response
                    if (!data) {
                        reject('Verification failed, please Login again.')
                    }
                    const {
                        roles,
                        roles_data,
                        name,
                        nick_name,
                        avatar,
                        email,
                        accessedRoutes,
                        permissions,
                        unreadNotificationCount
                    } = data
                    // roles must be a non-empty array
                    // roles must be a non-empty array
                    if (!roles || roles.length <= 0) {
                        reject('getInfo: roles or permissions must be a non-null array!')
                    }
                    if (permissions && permissions.length > 0) {
                        accessedRoutes.push({
                            hidden: true,
                            name: 'user-perimissions',
                            path: 'user-perimissions',
                            children: permissions
                        })
                    }

                    commit('SET_ROLES', roles)
                    commit('SET_NAME', name)
                    commit('SET_NICKNAME', nick_name)
                    commit('SET_AVATAR', avatar)
                    commit('SET_INTRODUCTION', email)
                    commit('SET_ACCESSEDROUTES', accessedRoutes)
                    commit('SET_UNREADNOTIFICATIONCOUNT', unreadNotificationCount)
                    commit('SET_ROLESDATA', roles_data)
                    resolve(data)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
    // user logout
    logout({commit, state, dispatch}) {
        return new Promise((resolve, reject) => {
            logout(state.token)
                .then(() => {
                    commit('SET_TOKEN', '')
                    commit('SET_ROLES', [])
                    commit('SET_ACCESSEDROUTES', [])
                    commit('SET_UNREADNOTIFICATIONCOUNT', 0)
                    commit('SET_ISTOKEN', true)
                    removeToken()
                    removeLoginType()
                    resetRouter()

                    resolve()
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
}
