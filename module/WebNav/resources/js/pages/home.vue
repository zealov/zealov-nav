<template>
    <div class="content_container no-bg">
        <el-scrollbar>
            <div>
                <div class="container">
                    <h1>关于项目</h1>
                    <p>这是一个开源的网址导航网站项目，您可以拿来制作自己的网址导航网站。</p>

                    <p>网站前台静态页面使用 <el-link style="font-size: 22px" href="http://layui.apixx.net/" target="_blank" type="primary">layui 。</el-link></p>

                    <p>如果对本项目有任何建议都可以发起 <el-link style="font-size: 22px" href="https://github.com/zealov/zealov-nav/issues" target="_blank" type="primary">issue。</el-link></p>
                    <h1>关于作者</h1>
                    <p>GitHub 地址：<el-link href="https://github.com/zealov/zealov-nav" style="font-size: 22px" target="_blank" type="primary">https://github.com/zealov/zealov-nav</el-link></p>

                    <p>E-mail 地址：921491025@qq.com</p>

                    <p>如果你有更好的想法，可以通过邮件与我联系，欢迎与我交流分享。</p>
                </div>
            </div>
        </el-scrollbar>
    </div>
</template>
<script>
export default {
    layout: 'basic',
    data() {
        return {
            data: {

            },
            isCollapse: true

        }
    },
    mounted() {
        // this.getUserInfo()
    },
    methods: {
        handleOpen(key, keyPath) {
            console.log(key, keyPath);
        },
        handleClose(key, keyPath) {
            console.log(key, keyPath);
        }
    }
}
</script>
<style>
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;
    min-height: 400px;
}
</style>
