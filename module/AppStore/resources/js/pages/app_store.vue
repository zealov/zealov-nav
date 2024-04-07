<template>
    <div class="content_container" >
        <div class="tabs">
            <el-tabs  v-model="search.tab" @tab-click="handleClick">
                <el-tab-pane name="appstore" label="模块市场"><span slot="label"><i class="el-icon-shopping-cart-2">模块市场</i></span>
                </el-tab-pane>
                <el-tab-pane name="installed" label="已安装"><span slot="label"><i class="el-icon-download">已安装</i></span>
                </el-tab-pane>
                <el-tab-pane name="enabled" label="已启用"><span slot="label"><i class="el-icon-finished">已启用</i></span>
                </el-tab-pane>
                <el-tab-pane name="disabled" label="已禁用"><span slot="label"><i class="el-icon-circle-close"></i> 已禁用</span>
                </el-tab-pane>
                <el-tab-pane name="system" label="系统模块"> <span slot="label"><i class="el-icon-setting"></i> 系统模块</span>
                </el-tab-pane>
            </el-tabs>
            <el-button
                v-if="!memberUser.id"
                :loading="memberUserLoading"
                       @click="doMemberLoginShow()"
                        class="topic-add-button">

                <span><i class="el-icon-user"></i> 去登录</span>
            </el-button>
            <span v-else-if="memberUser.id>0"  class="topic-add-button">
                    <el-dropdown>
                         <el-button type="primary">
                             {{memberUser.name}}<i class="el-icon-arrow-down el-icon--right"></i>
                          </el-button>
                      <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item  @click.native="loginout()">退出登录</el-dropdown-item>
                      </el-dropdown-menu>
                    </el-dropdown>
                </span>
        </div>
        <div class="app_store_black">
            <el-row  :gutter="20">
                <el-col :span="6" v-for="(module, moduleIndex) in filterModules" :key="o">
                    <el-card :body-style="{ padding: '0px' }">
                        <el-image :src="module.cover" style=" max-height: 200px;width: 100%" fit="cover"></el-image>
                        <div style="padding: 14px;">
                            <b>{{ module.title }} </b><span class="red p-5">{{module.price ? '￥' + module.price : '免费'}}</span><span>版本：V{{ module.latestVersion }}</span>
                            <div class="bottom clearfix" style="margin-top: 10px">
                                <el-button type="primary" icon="el-icon-plus" plain size="mini">其他版本</el-button>
                            </div>
                            <div v-if="!module._isSystem" style="margin-top: 10px">
                                <div v-if="!module._isInstalled">
                                    <el-button type="text" @click="doInstall(module)">安装</el-button>
                                </div>
                                <a v-if="module._isInstalled && module._isEnabled" style="color: red;margin-right: 15px"
                                   type="text"
                                   @click="doDisable(module)">
                                    禁用
                                </a>
                                <a v-if="module._isInstalled && !module._isEnabled"
                                   style="color: green;margin-right: 15px" type="text"
                                   @click="doEnable(module)">
                                    启用
                                </a>
                                <a v-if="module._isInstalled && !module._isEnabled"
                                   style="color: red;margin-right: 15px" type="text"
                                   @click="doUninstall(module)">
                                    卸载
                                </a>
                            </div>
                            <div v-else style="margin-top: 10px">
                                <a v-if="module._isInstalled &&  !module._isLocal && versionCompare(module.latestVersion,module._localVersion)>0"
                                   style="color: red;margin-right: 15px" type="text"
                                   @click="doUpgrade(module)"><i class="el-icon-top">升级</i>
                                </a>
                            </div>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
        </div>
        <el-dialog :visible.sync="memberUserShow" width="560px" title="账户密码登录" center
                   :close-on-click-modal="false" class="dialog_tc">
            <el-form
                ref="loginForm"
                :model="memberLoginForm"
                label-width="120px"
                size="medium"

            >
                <el-form-item
                    prop="email"
                    label="邮箱账户："
                    required
                    :error="memberLoginError.email ? memberLoginError.email[0] : ''"
                    :rules="[{required:true,type:'email',message:'请输入邮箱账户',trigger:'blur'}]"
                >
                    <el-input
                        type="text"
                        placeholder="请输入用户名"
                        v-model="memberLoginForm.email"
                    ></el-input>
                </el-form-item>
                <el-form-item
                    prop="password"
                    label="密码："
                    required
                    :error="memberLoginError.password ? memberLoginError.password[0] : ''"
                    :rules="[{required:true,message:'请输入密码',trigger:'blur'}]"
                >
                    <el-input
                        type="text"
                        placeholder="请输入密码"
                        v-model="memberLoginForm.password"
                    ></el-input>
                </el-form-item>
                <el-form-item class="captcha-item" prop="captcha" label="验证码："
                              :rules="[{required:true,message:'请输入密码',trigger:'blur'}]"
                              :error="memberLoginError.captcha ? memberLoginError.captcha[0] : ''" required>
                    <el-input
                        v-model="memberLoginForm.captcha"
                        type="text"
                        placeholder="请输入验证码"
                    >
                    </el-input>
                    <img :src="captchaImg" alt="图片验证码" @click="getCaptcha">
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
                    <el-button @click="memberUserShow = false">取消</el-button>
                    <el-button
                        type="primary"
                        :loading="loginLoading"
                        @click="doLogin('loginForm')"
                    >保存</el-button>
                </span>
        </el-dialog>
        <el-dialog :visible.sync="commandDialogShow"
                   :show-close="commandDialogFinish"
                   :close-on-press-escape="false"
                   :close-on-click-modal="false"
                   append-to-body>
            <div slot="title">
                <div class="ub-text-bold ub-text-primary">
                    <i class="el-icon-sort"></i>
                    {{ commandDialogTitle }}
                </div>
            </div>
            <div class="dialog-block">
                <div v-for="(msg,msgIndex) in commandDialogMsgs" v-html="msg"></div>
                <div v-if="!commandDialogFinish">
                    <i class="el-icon-loading"></i>
                    当前操作已运行 {{ commandDialogRunElapse }} s ...
                </div>
                <div v-else>
                    <i class="el-icon-circle-check"></i>
                    操作已运行完成
                </div>
            </div>
            <div class="dialog_footer" v-if="commandDialogFinish">
                <el-button type="danger" @click="commandDialogShow=false" size="mini">关闭</el-button>
            </div>
        </el-dialog>
    </div>

</template>

<script>
import {custom} from '../api/appStore'
import {
    getToken,
    setToken,
    removeToken,
} from '../utils/auth'
import axios from 'axios';

export default {
    data() {
        return {
            search: {
                tab: 'appstore',
                priceType: 'all',
                isRecommend: false,
                categoryId: 0,
                type: '',
                keywords: '',
            },
            captchaImg: '',
            memberLoginError: {},
            modules: [],
            commandDialogShow: false,
            commandDialogFinish: true,
            commandDialogTitle: '',
            commandDialogMsgs: [],
            commandDialogRunElapse: 0,
            memberUserLoading: false,
            memberUserShow: false,
            loginLoading: false,
            memberUser: {
                id: 0,
                name: '',
                avatar: '',
            },
            memberLoginForm: {
                email: '',
                password: '',
                captcha: '',
                agree: false,
                captchaKey: ''
            },
        }
    },
    mounted() {
        this.doLoad()
        this.loadingMember()
        setInterval(() => {
            this.commandDialogRunElapse = parseInt(((new Date()).getTime() - this.commandDialogRunStart) / 1000)
        }, 1000)
        this.getCaptcha()
    },
    computed:{

        filterModules(){
            console.log(this.modules)
            const results = this.modules.filter(module => {
                switch (this.search.tab) {
                    case 'appstore':
                        if (module._isLocal) return false
                        if (module._isSystem) return false
                        break
                    case 'installed':
                        if (!module._isInstalled) return false
                        if (module._isSystem) return false
                        break;
                    case 'enabled':
                        if (!module._isEnabled) return false
                        if (module._isSystem) return false
                        break;
                    case 'disabled':
                        if (!module._isInstalled || module._isEnabled) return false
                        if (module._isSystem) return false
                        break;
                    case 'system':
                        if (!module._isSystem) return false
                        break
                }
                return true
            })
            return results
        }
    },
    methods: {
        versionCompare(left, right) {
            let a = left.split('.'), b = right.split('.')

            for (let i = 0, len = Math.max(a.length, b.length); i < len; i++) {
                if ((a[i] && !b[i] && parseInt(a[i]) > 0) || (parseInt(a[i]) > parseInt(b[i]))) {
                    return 1;
                } else if ((b[i] && !a[i] && parseInt(b[i]) > 0) || (parseInt(a[i]) < parseInt(b[i]))) {
                    return -1;
                }
            }
            return 0;
        },
        loadingMember(){
            let access_token = getToken()
            if(access_token){
                axios.post(`${window.config.apiBase}/api/store/me`,{}, {
                    headers: {
                        'Authorization': 'Bearer ' + access_token
                    }
                }).then(response => {
                    this.memberUser.id=response.data.data.id
                    this.memberUser.name=response.data.data.nick_name?response.data.data.nick_name:response.data.data.name
                })
            }

        },
        doLogin(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    axios.post(`${window.config.apiBase}/api/store/login`, this.memberLoginForm).then(response => {
                        this.$message({
                            message: '登录成功',
                            type: 'success'
                        });
                        //拿到token，根据token获取用户数据
                        let access_token = response.data.data.access_token
                        let expires_in = response.data.data.expires_in
                        let seconds = expires_in ? expires_in : 7200
                        let expires = new Date(new Date() * 1 + seconds * 1000)
                        setToken(access_token, expires)
                        axios.post(`${window.config.apiBase}/api/store/me`,{}, {
                            headers: {
                                'Authorization': 'Bearer ' + access_token
                            }
                        }).then(response => {
                            this.memberUser.id=response.data.data.id
                            this.memberUser.name=response.data.data.nick_name?response.data.data.nick_name:response.data.data.name
                        })
                        this.$refs[formName].resetFields();
                        this.memberUserShow=false
                    }).catch(error => {
                        this.memberLoginError = error.response.data.data
                    })
                } else {

                    return false
                }
            })

        },
        getCaptcha() {
            axios.post(`${window.config.apiBase}/api/store/captcha`).then(response => {
                this.captchaImg = response.data.data.img
                this.memberLoginForm.captchaKey = response.data.data.key
            })
        },
        doMemberLoginShow() {
            if (this.memberUser.id > 0) {
                this.memberUserShow = false
            } else {
                this.getCaptcha()
                this.memberUserShow = true
            }
        },
        loginout(){
            removeToken()
            this.$message({
                message: '退出成功！',
                type: 'success'
            });
            this.memberUser.id=""
            this.memberUser.name=""
        },
        handleClick(tab, event) {
            console.log(tab, event);
        },
        doEnable(module) {
            this.doCommand('enable', {
                module: module.name,
                version: module._localVersion
            }, null, `启用模块 ${module.title}（${module.name}）`)
        },
        doDisable(module) {
            this.doCommand('disable', {
                module: module.name,
            }, null, `禁用模块 ${module.title}（${module.name}）`)
        },
        doInstall(module) {
            this.doCommand('install', {
                module: module.name,
                version: module.latestVersion,
                isLocal: module._isLocal
            }, null, `安装模块 ${module.title}（${module.name}） V${module.latestVersion}`)
        },
        doUninstall(module) {
            this.$confirm('确认卸载?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.doCommand('uninstall', {
                    module: module.name,
                    version: module._localVersion,
                    isLocal: module._isLocal
                }, null, `卸载模块 ${module.title}（${module.name}）`)
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消卸载'
                });
            });
        },
        doCommand(command, data, step, title) {
            step = step || null
            title = title || null
            if (null === step) {
                this.commandDialogMsgs = []
                this.commandDialogShow = true
                this.commandDialogFinish = false
            }
            if (title) {
                this.commandDialogTitle = title
                this.commandDialogMsgs.push('<i class="el-icon-minus"></i> ' + title)
            }
            this.commandDialogRunStart = (new Date()).getTime()
            this.commandDialogRunElapse = 0
            let access_token = getToken()
            custom(command, {
                token: access_token,
                step: step,
                data: JSON.stringify(data)
            }).then(res => {
                if (Array.isArray(res.data.msg)) {
                    this.commandDialogMsgs = this.commandDialogMsgs.concat(res.data.msg)
                } else {
                    this.commandDialogMsgs.push(res.data.msg)
                }
                if (res.data.finish) {
                    this.commandDialogFinish = true
                    this.doLoad()
                    return
                } else {
                    setTimeout(() => {
                        this.doCommand(res.data.command, res.data.data, res.data.step)
                    }, 1000)
                }
            }).catch(res => {
                this.commandDialogMsgs.push('<i class="el-icon-close text-danger"></i> <span class="text-danger">' + res.message + '</span>')
                this.commandDialogFinish = true
                return true
            })

        },
        doUpgrade(module) {
            this.$confirm('确认升级?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.doCommand('upgrade', {
                    module: module.name,
                    version: module.latestVersion,
                }, null, `升级模块 ${module.title}（${module.name}） V${module.latestVersion}`)
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消升级模块'
                });
            });
        },
        doLoad() {
            custom('all', {}).then(res => {
                this.modules = res.data.modules
                console.log(res, 'res')

            }).catch(res => {
                console.log(res)

            })
        },
    },

}
</script>
