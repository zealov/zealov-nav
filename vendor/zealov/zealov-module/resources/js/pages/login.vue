<template>
    <div class="login-page">
        <el-scrollbar>
            <div class="login">
                <div class="login-top">
                    <div class="logo-box">
                        后台管理系统
                    </div>
                </div>
                <div
                    class="login-container bg-login"
                >
                    <el-row :gutter="30">
                        <el-col :xs="24" :sm="24" :md="12" class="left-col">
                            <div class="login-left">
                                <div class="img">
<!--                                    <img src="/images/img_login.png" alt="">-->
                                </div>
                            </div>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="12">
                            <div class="login-wrapper">
                                <!-- 账号登陆 -->
                                <div class="account-login">
                                    <el-tabs v-model="activeTab">
                                        <!-- 账号密码登录 -->
                                        <el-tab-pane label="账号密码登录" name="accountLogin">
                                            <el-form
                                                ref="loginForm"
                                                :model="loginForm"
                                                status-icon
                                                :rules="rules"
                                            >
                                                <el-form-item prop="name" :error="error.name ? error.name[0] : ''">
                                                    <el-input
                                                        v-model="loginForm.name"
                                                        type="text"
                                                        placeholder="账户"
                                                        @keyup.enter.native="userLogin"
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-input__icon el-icon-user"
                                                        />
                                                    </el-input>
                                                </el-form-item>
                                                <el-form-item
                                                    prop="password"
                                                    :error="error.password ? error.password[0] : ''"
                                                >
                                                    <el-input
                                                        v-model="loginForm.password"
                                                        type="password"
                                                        placeholder="请输入密码"
                                                        @keyup.enter.native="userLogin"
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-input__icon el-icon-lock"
                                                        />
                                                    </el-input>
                                                </el-form-item>
                                                <el-form-item class="captcha-item" prop="code"
                                                              :error="error.code ? error.code[0] : ''">
                                                    <el-input
                                                        v-model="loginForm.code"
                                                        type="text"
                                                        placeholder="请输入验证码"
                                                        @keyup.enter.native="userLogin"
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-input__icon el-icon-chat-dot-round"
                                                        />
                                                    </el-input>
                                                    <img :src="captchaImg" alt="图片验证码" @click="getCaptcha">
                                                </el-form-item>
                                                <el-form-item style="margin-bottom: 5px"/>
                                                <el-form-item>
                                                    <el-button :loading="loading" type="primary" plain
                                                               @click="userLogin">
                                                        立即登录
                                                    </el-button>
                                                </el-form-item>
                                            </el-form>
                                        </el-tab-pane>
                                    </el-tabs>
                                </div>
                            </div>
                        </el-col>
                    </el-row>
                </div>
                <div class="login-footer">
                    支持的浏览器有：IE版本9以上，Chrome,Safari,Firefox，国内浏览器请使用极速模式。 技术支持：waigaoqiao_top
                </div>
            </div>
        </el-scrollbar>
    </div>
</template>
<script>
import {login, captcha} from '../api/user'

export default {
    layout: 'default',
    data() {
        return {
            error: {},
            captchaImg: '',
            activeTab: 'accountLogin',
            loginForm: {
                name: '',
                password: '',
                code: '',
                captchaKey: ''
            },
            rules: {
                name: [{
                    required: true,
                    message: '账号不能为空',
                    trigger: 'blur'
                }],
                code: [{
                    required: true,
                    message: '验证码不能为空',
                    trigger: 'blur'
                }],
                password: [
                    {
                        required: true,
                        message: '密码不能为空',
                        trigger: 'blur'
                    },
                    {
                        min: 6,
                        max: 30,
                        message: '长度在 6 到 30 个字符',
                        trigger: 'blur'
                    }
                ],
                phone: [
                    {
                        required: true,
                        message: '请输入手机号码',
                        trigger: 'blur'
                    },
                    {
                        pattern: /^1[34578]\d{9}$/,
                        message: '请输入正确的手机号'
                    }
                ]
            },

            totalTime: 45,
            canClick: false,
            loading: false,
            jaccountAllow: '',
            can_register: false
        }
    },
    // watch: {
    //     $route: {
    //         handler: function (route) {
    //             const query = route.query
    //             if (query) {
    //                 this.redirect = query.redirect
    //                 this.otherQuery = this.getOtherQuery(query)
    //             }
    //         },
    //         immediate: true
    //     }
    // },
    created() {
        this.getCaptcha()
    },
    methods: {
        getCaptcha() {
            captcha({}).then((response) => {
                this.captchaImg = response.data.img
                this.loginForm.captchaKey = response.data.key
            })
        },
        userLogin() {
            this.$refs.loginForm.validate((valid) => {
                if (valid) {
                    this.handleLogin()
                } else {
                    return false
                }
            })
        },
        handleLogin() {
            this.loading = true
            this.error = {}
            this.$store.dispatch('user/login', this.loginForm).then((response) => {
                // this.$router.push({
                //     path: this.redirect || '/admin/home',
                //     query: this.otherQuery
                // })
                window.location.href= this.redirect || '/admin/home',
                this.loading = false
            }).catch((err) => {
                this.error = err.data
                this.loading = false
            })
        },
        checkCapslock(e) {
            const {key} = e
            this.capsTooltip = key && key.length === 1 && key >= 'A' && key <= 'Z'
        },
        getOtherQuery(query) {
            return Object.keys(query).reduce((acc, cur) => {
                if (cur !== 'redirect') {
                    acc[cur] = query[cur]
                }
                return acc
            }, {})
        }
    }

}
</script>
