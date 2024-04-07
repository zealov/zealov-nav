import axios from 'axios'
import { MessageBox, Message, Notification } from 'element-ui'
import store from '~/store'
import router from '~/router'
import {getBaseApi} from './index'
import {removeLoginType, removeToken} from "./auth";
const base_api = getBaseApi()
// create an axios instance
const service = axios.create({
    baseURL: base_api, // url = base url + request url
    // withCredentials: true, // send cookies when cross-domain requests
    timeout: 10000 // request timeout
})
// request interceptor
service.interceptors.request.use(
    (config) => {
        config.headers.Lang = 'zh-CN'
        const token = store.getters['user/token']
        if (token) {
            // let each request carry token
            // please modify it according to the actual situation
            config.headers.Authorization = 'Bearer ' + token
        }
        return config
    },
    (error) => {
        // do something with request error
        return Promise.reject(error)
    }
)
// 是否正在刷新的标记
let isRefreshing = false
// 重试队列，每一项将是一个待执行的函数形式
let requests = []

// response interceptor
service.interceptors.response.use(
    /**
     * If you want to get http information such as headers or status
     * Please return  response => response
     */

    /**
     * Determine the request status by custom code
     * Here is just an example
     * You can also judge the status by HTTP Status Code
     */
    (response) => {
        return response.data
    },
    (error) => {
        if (error.response !== undefined) {
            const { data } = error.response
            if (data.code === 430) {
                MessageBox.confirm(data.message, '', {
                    type: 'warning'
                }).then(() => {
                    removeToken()
                    removeLoginType()
                    window.location.href='/admin/login'

                })
            } else if (data.code === 401) {
                const config = error.response.config
                if (!isRefreshing) {
                    isRefreshing = true
                    return refreshToken()
                        .then((res) => {
                            const { access_token } = res
                            setToken(access_token)
                            config.headers.Authorization = 'Bearer ' + access_token
                            config.baseURL = ''
                            requests.forEach((cb) => cb(access_token))
                            requests = []
                            return service(config)
                        })
                        .finally(() => {
                            isRefreshing = false
                        })
                } else {
                    // 正在刷新token，将返回一个未执行resolve的promise
                    return new Promise((resolve) => {
                        // 将resolve放进队列，用一个函数形式来保存，等token刷新后直接执行
                        requests.push((token) => {
                            config.headers.Authorization = 'Bearer ' + token
                            config.baseURL = ''
                            resolve(service(config))
                        })
                    })
                }
            } else if (data.code === 500) {
                Notification.error({
                    title: data.message,
                    dangerouslyUseHTMLString: true,
                    message: `<p>ErrorNumber:${data.data.errorId}</p> We'll deal with it as soon as possible`,
                    duration: 0
                })
            } else if (data.code === 422) {
                return Promise.reject(data)
            } else {
                Message({
                    message: data.message,
                    type: 'error',
                    duration: 5 * 1000
                })
            }
            return Promise.reject(error)
        } else {
            MessageBox.alert(error.message, error.name, {
                type: 'error',
                closeOnClickModal: false,
                closeOnPressEscape: false,
                closeOnHashChange: false,
                roundButton: true
            })

            return Promise.reject(error)
        }
    }
)
function refreshToken () {
    return service.post('/refresh').then((response) => response.data)
}
export default service
