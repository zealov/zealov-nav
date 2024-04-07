import {constantRoutes} from '~/router'
import store from '~/store'
import Basic from '../../layouts/basic'
import Iframe from '../../layouts/iframe'
import {newFormatUrl} from "../../utils/index";

/**
 * Use meta.role to determine if the current user has permission
 * @param roles
 * @param route
 */
function hasPermission(roles, route) {
    if (route.meta && route.meta.roles) {
        return roles.some((role) => route.meta.roles.includes(role))
    } else {
        return true
    }
}

/**
 * 把后台返回菜单组装成routes要求的格式
 * @param {*} routes
 */
export function getAsyncRoutes(routes,label) {
    const res = []
    const keys = [
        'path',
        'name',
        'children',
        'redirect',
        'alwaysShow',
        'meta',
        'hidden',
        'label'
    ]
    routes.forEach((item) => {
        const newItem = {}
        if (item.component) {
            if (item.component === 'basic') {
                newItem.component = Basic
            }else if(item.component === 'iframe'){
                newItem.component = Iframe
                if(item.meta.iframe!=undefined){
                    item.meta.iframe = newFormatUrl(item.meta.iframe)
                }
            }else{
                newItem.component = () => import('~/pages/' + item.component + '.vue').then(m => m.default || m)
            }
        }
        for (const key in item) {
            if (keys.includes(key)) {
                newItem[key] = item[key]
            }
        }
        // if(newItem['label'] != label){
        //     newItem['path'] = newFormatUrl(item['path'])
        // }
        if (newItem.children && newItem.children.length) {
            newItem.children = getAsyncRoutes(item.children,label)
        }
        res.push(newItem)
    })
    return res
}

/**
 * Filter asynchronous routing tables by recursion
 * @param routes asyncRoutes
 * @param roles
 */
export function filterAsyncRoutes(routes, roles) {
    const res = []

    routes.forEach((route) => {
        const tmp = {...route}
        if (hasPermission(roles, tmp)) {
            if (tmp.children) {
                tmp.children = filterAsyncRoutes(tmp.children, roles)
            }
            res.push(tmp)
        }
    })

    return res
}

export const state = {
    routes: [],
    addRoutes: []
}

export const getters = {
    routes: state => state.routes,
}

export const mutations = {
    SET_ROUTES: (state, routes) => {
        state.addRoutes = routes
        state.routes = constantRoutes.concat(routes)
    }
}

export const actions = {
    generateRoutes({commit}, {routes,label}) {
        return new Promise((resolve, reject) => {
            let accessedRoutes
            // const routes = store.getters.accessedRoutes // 获取到后台路由
            const roles = store.getters['user/roles'] // 获取到用户角色
            const asyncRoutes = getAsyncRoutes(routes,label) // 对路由格式进行处理
            if (roles.includes('admin-none')) {
                accessedRoutes = asyncRoutes || []
            } else {
                // 这里是有做权限过滤的,如果不需要就不用
                accessedRoutes = filterAsyncRoutes(asyncRoutes, roles)
            }
            commit('SET_ROUTES', accessedRoutes)
            resolve(accessedRoutes)
        })
    }
}


