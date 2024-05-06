const { join, resolve } = require('path')
const { copySync, removeSync } = require('fs-extra')
const mix = require('laravel-mix')
require('laravel-mix-versionhash')
let mod = __dirname.replace(/^.+[\/\\]([A-Za-z0-9]+)/, '$1')
const NodePolyfillPlugin = require('node-polyfill-webpack-plugin')
mix.webpackConfig({
    plugins: [
        new NodePolyfillPlugin()
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '~': join(__dirname, './resources/js'),
            '@': join(__dirname+'/../../vendor/zealov/zealov-module', './resources/js'),
        }
    },
    output: {
        publicPath:'/module/'+modName()+'/back/',
        path:resolve(__dirname,output(__dirname)),
    },
    externals: {
        'vue': 'Vue',
        'element-ui': 'ELEMENT',
        'jquery': 'window.$',
    }
})
mix.js('resources/js/app.js', 'js').vue({
    extractStyles: true
}).sass('resources/sass/app.scss', 'css')
    .disableNotifications()
    .setResourceRoot('/module/'+modName()+'/back')
    .setPublicPath(output(__dirname))


if (mix.inProduction()) {
    mix.versionHash().then(() => {
        process.nextTick(() => publishAseets())
    })
} else {
    mix.sourceMaps().copy('public','../../public/module')
}

function modName(){
    return __dirname.replace(/^.+[\/\\]([A-Za-z0-9]+)/, '$1')
}

function output(dirname){
    let mod = dirname.replace(/^.+[\/\\]([A-Za-z0-9]+)/, '$1')
    return mix.inProduction()? './public/build': './public/'+mod+'/back'
}

function publishAseets () {
    let mod = __dirname.replace(/^.+[\/\\]([A-Za-z0-9]+)/, '$1')
    const publicDir = resolve(__dirname, './public')

    removeSync(join(publicDir, mod+'/back'))

    copySync(join(publicDir, 'build'), join(publicDir, mod+'/back'))

    removeSync(join(publicDir, 'build'))

    removeSync(resolve(__dirname,'../../public/module/'+mod+'/build'))

    removeSync(resolve(__dirname,'../../public/module/'+mod+'/back'))

    copySync(join(publicDir), resolve(__dirname,'../../public/module'))

}
