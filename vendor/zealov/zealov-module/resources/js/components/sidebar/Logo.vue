<template>
    <div class="sidebar-logo-container"
         :class="{ collapse: collapse }">
        <transition name="sidebarLogoFade">
            <router-link v-if="collapse"
                         key="collapse"
                         class="sidebar-logo-link"
                         to="/">
                <img v-if="logo"
                     :src="logo"
                     class="sidebar-logo"/>
                <h1 v-else
                    class="sidebar-title">{{ title }}</h1>
            </router-link>
            <router-link v-else
                         key="expand"
                         class="sidebar-logo-link"
                         to="/">
                <img v-if="logo"
                     :src="logo"
                     class="sidebar-logo"/>
                <h1 class="sidebar-title">{{ title }}</h1>
            </router-link>
        </transition>
    </div>
</template>

<script>
export default {
    name: 'SidebarLogo',
    props: {
        collapse: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            title: '后台管理系统',
            logo: ''
        }
    }
}
</script>

<style lang="scss" scoped>
.sidebarLogoFade-enter-active {
    transition: opacity 1.5s;
}

.sidebarLogoFade-enter,
.sidebarLogoFade-leave-to {
    opacity: 0;
}

.sidebar-logo-container {
    position: relative;
    width: 100%;
    height: 50px;
    line-height: 50px;
    background: #263445;
    text-align: center;
    overflow: hidden;

    & .sidebar-logo-link {
        height: 100%;
        width: 100%;

        & .sidebar-logo {
            width: 36px;
            height: 36px;
            vertical-align: middle;
            margin-right: 12px;
        }

        & .sidebar-title {
            display: inline-block;
            margin: 0;
            color: #fff;
            font-weight: normal;
            line-height: 50px;
            font-size: 18px;
            font-family: Avenir, Helvetica Neue, Arial, Helvetica, sans-serif,
            '微软雅黑';
            vertical-align: middle;
        }
    }

    &.collapse {
        .sidebar-logo {
            margin-right: 0px;
        }
    }
}
</style>
