<template>
    <div style="padding: 5px">
        <iframe  width="100%"  :height="calHeight"  :src="iframe" id="myIframe" frameborder="0"></iframe>
    </div>

</template>

<script>
export default {
    name: "index",
    data() {
        return {
            iframe: "",
        };
    },
    computed:{
        calHeight(){
            return window.innerHeight-50+'px'
        }
    },
    mounted() {
        // 从路由里动态获取 url地址   具体地址看libs下util.js里的 backendMenuToRoute  方法
        this.getiframe();
    },
    watch: {
        $route: async function() {
            // 监听路由变化
            await this.getiframe();
        }
    },
    methods: {
        getiframe() {
            this.iframe = this.$route.meta.iframe;
        }
    }
};
</script>

<style lang="scss" scoped>

</style>
