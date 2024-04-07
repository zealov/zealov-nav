export const state = {
    theme: '#1890ff',
    showSettings: false,
    tagsView: false,
    fixedHeader: false,
    sidebarLogo: true
}
export const getters = {
    theme: state => state.theme,
    showSettings: state => state.showSettings,
    tagsView: state => state.tagsView,
    fixedHeader: state => state.fixedHeader,
    sidebarLogo: state => state.sidebarLogo
}

export const mutations = {
    CHANGE_SETTING: (state, {key, value}) => {
        // eslint-disable-next-line no-prototype-builtins
        if (state.hasOwnProperty(key)) {
            state[key] = value
        }
    }
}

export const actions = {
    changeSetting({commit}, data) {
        commit('CHANGE_SETTING', data)
    }
}


