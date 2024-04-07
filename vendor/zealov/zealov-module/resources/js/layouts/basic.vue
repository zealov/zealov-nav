<template>
    <div :class="classObj"  class="app-wrapper">
        <leftMenu class="sidebar-container"/>
        <div class="main-container">
            <headerTop/>
            <app-main/>
        </div>
    </div>

</template>

<script>

import headerTop from '../components/public/header'
import leftMenu from '../components/public/left_menu'
import AppMain from '../layouts/main'
import { mapState } from 'vuex'
export default {
    name: 'BasicLayout',
    components: {
        headerTop,
        leftMenu,
        AppMain
    },
    computed: {
        ...mapState({
            sidebar: state => state.app.sidebar,
            device: state => state.app.device,
        }),
        classObj() {
            return {
                hideSidebar: !this.sidebar.opened,
                openSidebar: this.sidebar.opened,
                withoutAnimation: this.sidebar.withoutAnimation,
                mobile: this.device === 'mobile'
            }
        }
    },
    data() {
        return {}
    },
    methods: {}
}
</script>
<style lang="scss" scoped>

.app-wrapper {
    position: relative;
    height: 100%;
    width: 100%;

    &.mobile.openSidebar {
        position: fixed;
        top: 0;
    }
}

.drawer-bg {
    background: #000;
    opacity: 0.3;
    width: 100%;
    top: 0;
    height: 100%;
    position: absolute;
    z-index: 999;
}

.hideSidebar .fixed-header {
    width: calc(100% - 54px)
}

.mobile .fixed-header {
    width: 100%;
}
</style>
