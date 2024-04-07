/**
 * Parse the time to string
 * @param {(Object|string|number)} time
 * @param {string} cFormat
 * @returns {string | null}
 */
export function parseTime(time, cFormat) {
    if (arguments.length === 0 || !time) {
        return null
    }
    const format = cFormat || '{y}-{m}-{d} {h}:{i}:{s}'
    let date
    if (typeof time === 'object') {
        date = time
    } else {
        if (typeof time === 'string') {
            if (/^[0-9]+$/.test(time)) {
                // support "1548221490638"
                time = parseInt(time)
            } else {
                // support safari
                // https://stackoverflow.com/questions/4310953/invalid-date-in-safari
                time = time.replace(new RegExp(/-/gm), '/')
            }
        }

        if (typeof time === 'number' && time.toString().length === 10) {
            time = time * 1000
        }
        date = new Date(time)
    }
    const formatObj = {
        y: date.getFullYear(),
        m: date.getMonth() + 1,
        d: date.getDate(),
        h: date.getHours(),
        i: date.getMinutes(),
        s: date.getSeconds(),
        a: date.getDay()
    }
    const time_str = format.replace(/{([ymdhisa])+}/g, (result, key) => {
        const value = formatObj[key]
        // Note: getDay() returns 0 on Sunday
        if (key === 'a') {
            return ['日', '一', '二', '三', '四', '五', '六'][value]
        }
        return value.toString().padStart(2, '0')
    })
    return time_str
}

/**
 * @param {string} time
 * @returns {string}
 */
export function rTime(time) {
    if (time === '') {
        // 解决deteForm为空传1970-01-01 00:00:00
        return ''
    } else if (time === undefined) {
        return ''
    } else {
        return new Date(+new Date(new Date(time).toJSON()) + 8 * 3600 * 1000)
            .toISOString()
            .replace(/T/g, ' ')
            .replace(/\.[\d]{3}Z/, '')
    }
}

/**
 * @param {number} time
 * @param {string} option
 * @returns {string}
 */
export function formatTime(time, option) {
    if (('' + time).length === 10) {
        time = parseInt(time) * 1000
    } else {
        time = +time
    }
    const d = new Date(time)
    const now = Date.now()

    const diff = (now - d) / 1000

    if (diff < 30) {
        return '刚刚'
    } else if (diff < 3600) {
        // less 1 hour
        return Math.ceil(diff / 60) + '分钟前'
    } else if (diff < 3600 * 24) {
        return Math.ceil(diff / 3600) + '小时前'
    } else if (diff < 3600 * 24 * 2) {
        return '1天前'
    }
    if (option) {
        return parseTime(time, option)
    } else {
        return (
            d.getMonth() +
            1 +
            '月' +
            d.getDate() +
            '日' +
            d.getHours() +
            '时' +
            d.getMinutes() +
            '分'
        )
    }
}

export function formatDate(numb, format) {
    const old = numb - 1
    const t = Math.round((old - Math.floor(old)) * 24 * 60 * 60)
    const time = new Date(1900, 0, old, 0, 0, t)
    const year = time.getFullYear()
    const month = time.getMonth() + 1
    const date = time.getDate()
    return (
        year +
        format +
        (month < 10 ? '0' + month : month) +
        format +
        (date < 10 ? '0' + date : date)
    )
}

/**
 * @param {string} url
 * @returns {Object}
 */
export function getQueryObject(url) {
    url = url == null ? window.location.href : url
    const search = url.substring(url.lastIndexOf('?') + 1)
    const obj = {}
    const reg = /([^?&=]+)=([^?&=]*)/g
    search.replace(reg, (rs, $1, $2) => {
        const name = decodeURIComponent($1)
        let val = decodeURIComponent($2)
        val = String(val)
        obj[name] = val
        return rs
    })
    return obj
}

/**
 * @param {string} input value
 * @returns {number} output value
 */
export function byteLength(str) {
    // returns the byte length of an utf8 string
    let s = str.length
    for (var i = str.length - 1; i >= 0; i--) {
        const code = str.charCodeAt(i)
        if (code > 0x7f && code <= 0x7ff) s++
        else if (code > 0x7ff && code <= 0xffff) s += 2
        if (code >= 0xdc00 && code <= 0xdfff) i--
    }
    return s
}

/**
 * @param {Array} actual
 * @returns {Array}
 */
export function cleanArray(actual) {
    const newArray = []
    for (let i = 0; i < actual.length; i++) {
        if (actual[i]) {
            newArray.push(actual[i])
        }
    }
    return newArray
}

/**
 * @param {Object} json
 * @returns {Array}
 */
export function param(json) {
    if (!json) return ''
    return cleanArray(
        Object.keys(json).map((key) => {
            if (json[key] === undefined) return ''
            return encodeURIComponent(key) + '=' + encodeURIComponent(json[key])
        })
    ).join('&')
}

/**
 * @param {string} url
 * @returns {Object}
 */
export function param2Obj(url) {
    const search = decodeURIComponent(url.split('?')[1]).replace(/\+/g, ' ')
    if (!search) {
        return {}
    }
    const obj = {}
    const searchArr = search.split('&')
    searchArr.forEach((v) => {
        const index = v.indexOf('=')
        if (index !== -1) {
            const name = v.substring(0, index)
            const val = v.substring(index + 1, v.length)
            obj[name] = val
        }
    })
    return obj
}

/**
 * @param {string} val
 * @returns {string}
 */
export function html2Text(val) {
    const div = document.createElement('div')
    div.innerHTML = val
    return div.textContent || div.innerText
}

/**
 * Merges two objects, giving the last one precedence
 * @param {Object} target
 * @param {(Object|Array)} source
 * @returns {Object}
 */
export function objectMerge(target, source) {
    if (typeof target !== 'object') {
        target = {}
    }
    if (Array.isArray(source)) {
        return source.slice()
    }
    Object.keys(source).forEach((property) => {
        const sourceProperty = source[property]
        if (typeof sourceProperty === 'object') {
            target[property] = objectMerge(target[property], sourceProperty)
        } else {
            target[property] = sourceProperty
        }
    })
    return target
}

/**
 * @param {HTMLElement} element
 * @param {string} className
 */
export function toggleClass(element, className) {
    if (!element || !className) {
        return
    }
    let classString = element.className
    const nameIndex = classString.indexOf(className)
    if (nameIndex === -1) {
        classString += '' + className
    } else {
        classString =
            classString.substr(0, nameIndex) +
            classString.substr(nameIndex + className.length)
    }
    element.className = classString
}

/**
 * @param {string} type
 * @returns {Date}
 */
export function getTime(type) {
    if (type === 'start') {
        return new Date().getTime() - 3600 * 1000 * 24 * 90
    } else {
        return new Date(new Date().toDateString())
    }
}

/**
 * @param {Function} func
 * @param {number} wait
 * @param {boolean} immediate
 * @return {*}
 */
export function debounce(func, wait, immediate) {
    let timeout, args, context, timestamp, result

    const later = function () {
        // 据上一次触发时间间隔
        const last = +new Date() - timestamp

        // 上次被包装函数被调用时间间隔 last 小于设定时间间隔 wait
        if (last < wait && last > 0) {
            timeout = setTimeout(later, wait - last)
        } else {
            timeout = null
            // 如果设定为immediate===true，因为开始边界已经调用过了此处无需调用
            if (!immediate) {
                result = func.apply(context, args)
                if (!timeout) context = args = null
            }
        }
    }

    return function (...args) {
        context = this
        timestamp = +new Date()
        const callNow = immediate && !timeout
        // 如果延时不存在，重新设定延时
        if (!timeout) timeout = setTimeout(later, wait)
        if (callNow) {
            result = func.apply(context, args)
            context = args = null
        }

        return result
    }
}

/**
 * This is just a simple version of deep copy
 * Has a lot of edge cases bug
 * If you want to use a perfect deep copy, use lodash's _.cloneDeep
 * @param {Object} source
 * @returns {Object}
 */
export function deepClone(source) {
    if (!source && typeof source !== 'object') {
        throw new Error('error arguments', 'deepClone')
    }
    const targetObj = source.constructor === Array ? [] : {}
    Object.keys(source).forEach((keys) => {
        if (source[keys] && typeof source[keys] === 'object') {
            targetObj[keys] = deepClone(source[keys])
        } else {
            targetObj[keys] = source[keys]
        }
    })
    return targetObj
}

/**
 * @param {Array} arr
 * @returns {Array}
 */
export function uniqueArr(arr) {
    return Array.from(new Set(arr))
}

/**
 * @returns {string}
 */
export function createUniqueString() {
    const timestamp = +new Date() + ''
    const randomNum = parseInt((1 + Math.random()) * 65536) + ''
    return (+(randomNum + timestamp)).toString(32)
}

/**
 * Check if an element has a class
 * @param {HTMLElement} elm
 * @param {string} cls
 * @returns {boolean}
 */
export function hasClass(ele, cls) {
    return !!ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'))
}

/**
 * Add class to element
 * @param {HTMLElement} elm
 * @param {string} cls
 */
export function addClass(ele, cls) {
    if (!hasClass(ele, cls)) ele.className += ' ' + cls
}

/**
 * Remove class from element
 * @param {HTMLElement} elm
 * @param {string} cls
 */
export function removeClass(ele, cls) {
    if (hasClass(ele, cls)) {
        const reg = new RegExp('(\\s|^)' + cls + '(\\s|$)')
        ele.className = ele.className.replace(reg, ' ')
    }
}

export function formatJson(filterVal, jsonData) {
    return jsonData.map((v) =>
        filterVal.map((j) => {
            return v[j]
        })
    )
}

export function setTypeName(options) {
    if (options && options.length > 0) {
        options.forEach((item) => {
            const {id, name, code} = item
            item.value = id
            item.label = name
            if (code) {
                item.value = code
            }
            if (item.disabled) {
                delete item.disabled
            }
            if (item.children) {
                if (item.children.length > 0) {
                    setTypeName(item.children)
                } else {
                    delete item.children
                }
            }
        })
    }
}

export function getTypeName(options, val, obj, name) {
    if (options && options.length > 0) {
        options.forEach((item) => {
            if (item.value === val) {
                obj[name] = item.label
            }
            if (item.children) {
                getTypeName(item.children, val, obj, name)
            }
        })
    }
}

export function getTypeCode(options, val, obj, name) {
    if (options && options.length > 0) {
        options.forEach((item) => {
            if (item.label === val) {
                obj[name] = item.value
            }
            if (item.children) {
                getTypeCode(item.children, val, obj, name)
            }
        })
    }
}

export function formatNumber(num) {
    return num.toString().replace(/\d+/, function (n) {
        // 先提取整数部分
        return n.replace(/(\d)(?=(\d{3})+$)/g, function ($1) {
            return $1 + ','
        })
    })
}

export function getPermissions(data) {
    let result = []
    data.forEach((item) => {
        if (item.hidden && item.name) {
            result.push(item.name)
        }
        if (item.children && item.children.length > 0) {
            result = result.concat(getPermissions(item.children))
        }
    })
    return result
}

export function formatUrl(url) {
    let newUrl = url
    if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
        newUrl = process.env.VUE_APP_BASE_URL + url
    }
    return newUrl
}

export function newFormatUrl(url) {
    let current_url = window.document.location.protocol + "//" + window.document.location.host;
    let newUrl = url
    if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
        let base_url = process.env.MIX_VUE_APP_EXTERNAL_URL
        if (base_url) {
            newUrl = base_url + url
        } else {
            newUrl = current_url + url
        }

    }
    return newUrl
}

export function getLabelRoute(path, options) {
    let label = ''
    if (options && options.length > 0) {
        for (let i = 0; i <= options.length; i++) {
            let item = options[i]
            if(item != undefined){
                path = path.replace(/\/\d+/, '/:id')
            }
            if (item != undefined && item.path == path) {
                 label = item.label
                break
            }
            if (item != undefined && item.children!=undefined && item.children.length != 0) {
                const label1 = getLabelRoute(path, item.children)
                if (label1) {
                    label = label1
                    break;
                }
            }
        }
    }

    return label
}

export function getBaseApi() {
    if (process.env.MIX_VUE_APP_BASE_API) {
        return process.env.MIX_VUE_APP_BASE_API
    }
    return window.document.location.protocol + "//" + window.document.location.host + "/api";
}

export function getBaseHost() {
    if (process.env.MIX_VUE_APP_BASE_Host) {
        return process.env.MIX_VUE_APP_BASE_Host
    }
    return window.document.location.protocol + "//" + window.document.location.host ;
}
//将字节转为标准格式
export function formatSize(limit) {
    var size = ''
    if (limit < 1024) {
        //小于0.1KB，则转化成B
        size = limit.toFixed(2) + 'B'
    } else if (limit <  1024 * 1024) {
        //小于0.1MB，则转化成KB
        size = (limit / 1024).toFixed(2) + 'KB'
    } else if (limit <  1024 * 1024 * 1024) {
        //小于0.1GB，则转化成MB
        size = (limit / (1024 * 1024)).toFixed(2) + 'MB'
    } else {
        //其他转化成GB
        size = (limit / (1024 * 1024 * 1024)).toFixed(2) + 'GB'
    }

    var sizeStr = size + '' //转成字符串
    var index = sizeStr.indexOf('.') //获取小数点处的索引
    var dou = sizeStr.substr(index + 1, 2) //获取小数点后两位的值
    if (dou == '00') {
        //判断后两位是否为00，如果是则删除00
        return sizeStr.substring(0, index) + sizeStr.substr(index + 3, 2)
    }
    return size
}
