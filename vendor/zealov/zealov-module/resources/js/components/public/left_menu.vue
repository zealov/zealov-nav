<template>
    <div :class="{'has-logo':showLogo}">
        <logo v-if="showLogo" :collapse="isCollapse" />
        <el-scrollbar wrap-class="scrollbar-wrapper">
            <el-menu
                :default-active="activeMenu"
                :collapse="isCollapse"
                background-color="#304156"
                text-color="rgba(191,203,217)"
                :unique-opened="false"
                active-text-color="#1890ff"
                :collapse-transition="false"
                mode="vertical"
            >
                <sidebar-item v-for="route in permission_routes" :key="route.path" :item="route" :base-path="route.path"/>
            </el-menu>
        </el-scrollbar>
    </div>
</template>

<script>
import SidebarItem from '../sidebar/sidebarItem'
import {mapGetters} from 'vuex'
import Logo from '../sidebar/Logo'

export default {
    computed: {
        ...mapGetters({permission_routes: 'permission/routes',sidebar:'app/sidebar',sidebarLogo:'settings/sidebarLogo'}),
        activeMenu() {
            const route = this.$route
            const { meta, path } = route
            // 如果设置了路径，侧边栏将突出显示您设置的路径
            if (meta.activeMenu) {
                return meta.activeMenu
            }
            return path
        },
        showLogo() {
            return this.sidebarLogo
        },
        isCollapse() {
            return !this.sidebar.opened
        }
    },
    components: {SidebarItem,Logo},
}
</script>
