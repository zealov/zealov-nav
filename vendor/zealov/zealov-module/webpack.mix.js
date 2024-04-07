const { join, resolve } = require('path')
const { copySync, removeSync } = require('fs-extra')
const mix = require('laravel-mix')
require('laravel-mix-versionhash')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

const NodePolyfillPlugin = require('node-polyfill-webpack-plugin')
mix.webpackConfig({
    plugins: [
        new NodePolyfillPlugin()
        // new BundleAnalyzerPlugin()
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '~': join(__dirname, './resources/js')
        }
    },
    output: {
        publicPath:'/vendor/zealov-basic/',
        path:resolve(__dirname,output(__dirname)),
    },
    externals: {
        'vue': 'Vue',
        'element-ui': 'ELEMENT',
        'jquery': 'window.$',
        //'echarts': 'echarts',
    }
})
mix.js('resources/js/app.js', 'js').vue({
    extractStyles: true
}).sass('resources/sass/app.scss', 'css')
    .disableNotifications()
    .setResourceRoot('/vendor/zealov-basic')
    .setPublicPath(output(__dirname))

if (mix.inProduction()) {
    mix.versionHash().then(() => {
        process.nextTick(() => publishAseets())
    })
} else {
    mix.sourceMaps().copy('public','../../../public/vendor')
}


function output(dirname){
    return mix.inProduction()? './public/build': './public/zealov-basic/'
}

function publishAseets () {

    const publicDir = resolve(__dirname, './public')

    removeSync(join(publicDir, 'zealov-basic'))

    copySync(join(publicDir, 'build'), join(publicDir, 'zealov-basic'))

    removeSync(join(publicDir, 'build'))

    removeSync(resolve(__dirname,'../../../public/vendor/build'))

    removeSync(resolve(__dirname,'../../../public/vendor/zealov-basic'))

    copySync(join(publicDir), resolve(__dirname,'../../../public/vendor'))

}
