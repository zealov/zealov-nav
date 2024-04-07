import Vue from 'vue'
import store from '../store'
import Meta from 'vue-meta'
import Router from 'vue-router'
import {sync} from 'vuex-router-sync'
import NProgress from 'nprogress' // progress bar
import basic from '../layouts/basic'
import {getToken} from '../utils/auth'
import {getLabelRoute} from '../utils'
import getPageTitle from '../utils/get-page-title'
Vue.use(Meta)
Vue.use(Router)
NProgress.configure({ showSpinner: false }) // NProgress Configuration

// Load middleware modules dynamically.

export const constantRoutes = [
    {
        path: '/admin/login',
        component: () => import('~/pages/login.vue').then(m => m.default || m),
        hidden: true
    },

    // { path: '*', component: () => import(/* webpackChunkName: '' */ `~/pages/errors/404.vue`).then(m => m.default || m) }
]
const router = createRouter()

sync(store, router)

export default router


function createRouter() {
    const router = new Router({
        scrollBehavior: () => ({ y: 0 }),
        mode: 'history',
        routes: constantRoutes
    })

    router.beforeEach(beforeEach)
    router.afterEach(afterEach)

    return router
}

export function resetRouter(routers) {
    if (routers) {
        routers = constantRoutes.concat(routers)
        const newRouter = new Router({
            mode: 'history',
            scrollBehavior: () => ({ y: 0 }),
            routes: routers
        })
        router.matcher = newRouter.matcher // reset router
    } else {
        const newRouter = createRouter()
        router.matcher = newRouter.matcher
    }
}

const whiteList = ['/admin/login'] // no redirect whitelist
// let isToken =

async function beforeEach(to, from, next) {
    // start progress bar
    NProgress.start()
    // set page title
    document.title = getPageTitle(to.meta.title)
    const hasToken = getToken()
    if (typeof hasToken != 'undefined') {
        if (to.path === '/admin/login') {
            next({path: '/admin/home'})
        } else {
            if (store.getters['user/isToken']) {
                try {
                    const {accessedRoutes} = await store.dispatch('user/getInfo')
                    //获取当前访问路由的标签
                    const label = getLabelRoute(to.path, accessedRoutes)
                    const accessRoutes = await store.dispatch(
                        'permission/generateRoutes',
                        {routes: accessedRoutes, label: label},
                    )
                    store.commit('user/SET_ACCESSEDROUTE', accessRoutes)

                    accessRoutes.forEach(res => {

                        router.addRoute(res)
                    })
                    store.commit('user/SET_ISTOKEN', false)//将isToken赋为 false ，否则会一直循环，崩溃
                    next({
                        ...to, // next({ ...to })的目的,是保证路由添加完了再进入页面 (可以理解为重进一次)
                        replace: true, // 重进一次, 不保留重复历史
                    })
                } catch (error) {
                    console.log(error)
                    Message.error(error || 'Has Error')
                    window.location.href='/admin/login'
                }
            } else {
                next()
            }

        }
    } else {
        if (whiteList.indexOf(to.path) !== -1) {
            // in the free login whitelist, go directly
            next()
        } else {
            // other pages that do not have permission to access are redirected to the login page.
            // next(`/admin/login?redirect=${to.path}`)
            window.location.href='/admin/login'
            NProgress.done()
        }
    }
}

async function afterEach(to, from, next) {
    await router.app.$nextTick()
    NProgress.done()
}

