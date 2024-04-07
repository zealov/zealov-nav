<template>
    <section class="app-main">
        <transition name="fade-transform" mode="out-in">
            <router-view />
        </transition>
    </section>
</template>

<script>
export default {
    name: 'AppMain',
}
</script>

<style lang="scss" scoped>
.app-main {
    /* 50= navbar  50  */
    min-height: calc(100vh - 50px);
    // height: 100vh;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.fixed-header+.app-main {
    padding-top: 50px;
    height: 100vh;
}

.hasTagsView {
    .app-main {
        min-height: calc(100vh - 84px);
    }

    .fixed-header+.app-main {
        padding-top: 84px;
    }
}
</style>

<style lang="scss">
// fix css style bug in open el-dialog
// .el-popup-parent--hidden {
//   .fixed-header {
//     padding-right: 15px;
//   }
// }
</style>
