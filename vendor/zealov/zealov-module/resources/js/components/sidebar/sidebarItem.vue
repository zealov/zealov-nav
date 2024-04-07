<template>
    <div v-if="!item.hidden">
        <template
            v-if="hasOneShowingChild(item.children,item) && (!onlyOneChild.children||onlyOneChild.noShowingChildren) &&!item.alwaysShow">
            <app-link v-if="onlyOneChild.meta" :to="resolvePath(onlyOneChild.path)">
                <el-menu-item :index="resolvePath(onlyOneChild.path)">
                    <div>
                        <i v-if="icon(onlyOneChild)" :class="icon(onlyOneChild)"/>
                        <i v-else style="margin-left: 12px">  </i>
                        <span slot="title">{{ onlyOneChild.meta.title }}</span>
                    </div>
                </el-menu-item>
            </app-link>
        </template>

        <el-submenu v-else ref="subMenu" :index="resolvePath(item.path)" popper-append-to-body>
            <template slot="title">
                <div v-if="item.meta">
                    <i v-if="icon(item)" :class="icon(item)"/>
                    <i v-else style="margin-left: 15px"></i>
                    <span slot="title">{{ item.meta.title }}</span>
                </div>
            </template>
            <sidebar-item
                v-for="child in item.children"
                :key="child.path"
                :is-nest="true"
                :item="child"
                :base-path="resolvePath(child.path)"
                class="nest-menu"
            />
        </el-submenu>
    </div>
</template>

<script>
import path from 'path'
import {isExternal} from '../../utils/validate'
import AppLink from './appLink'

export default {
    name: 'SidebarItem',
    components: {AppLink},
    props: {
        item: {
            type: Object,
            required: true
        },
        isNest: {
            type: Boolean,
            default: false
        },
        basePath: {
            type: String,
            default: ''
        }
    },
    data() {
        this.onlyOneChild = null
        return {}
    },
    methods: {
        icon(item) {
            if (item.meta && item.meta.icon) {
                return item.meta.icon
            }
            return "";
        },
        hasOneShowingChild(children = [], parent) {
            const showingChildren = children.filter(item => {
                if (item.hidden) {
                    return false
                } else {
                    // 临时设置（如果只有一个显示的子项，将使用）
                    this.onlyOneChild = item
                    return true
                }
            })

            // 当只有一个子路由器时，默认情况下会显示子路由器
            if (showingChildren.length === 1) {
                return true
            }

            // 如果没有要显示的子路由器，则显示父路由器
            if (showingChildren.length === 0) {
                this.onlyOneChild = {...parent, path: '', noShowingChildren: true}
                return true
            }

            return false
        },
        resolvePath(routePath) {
            if (isExternal(routePath)) {
                return routePath
            }
            if (isExternal(this.basePath)) {
                return this.basePath
            }
            return path.resolve(this.basePath, routePath)
        }
    }

}

</script>
<style>
.nest-menu .svg-icon {
    /* display: none; */
    width: 0px !important;
}
</style>
