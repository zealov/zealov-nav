import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

// Load store modules dynamically.
//加载多个模块

const requireContext = require.context(__dirname+'/../../../../../vendor/zealov/zealov-module/resources/js/store/modules', false, /.*\.js$/)

let modules = requireContext.keys()
    .map(file =>
        [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
    )
    .reduce((modules, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true
        }

        return { ...modules, [name]: module }
    }, {})
const requireContextCurrent = require.context('./modules', false, /.*\.js$/)

let modulesCurrent = requireContextCurrent.keys()
    .map(file =>
        [file.replace(/(^.\/)|(\.js$)/g, ''), requireContextCurrent(file)]
    )
    .reduce((modules, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true
        }

        return { ...modules, [name]: module }
    }, {})
const modulesAll = Object.assign(modules, modulesCurrent);
// console.log(modulesAll)
export default new Vuex.Store({
    modules: modulesAll,
})


