"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[151],{9151:(t,a,n)=>{n.r(a),n.d(a,{default:()=>l});var i=n(4319);function s(t,a){return(0,i.Z)({url:"/appStore/"+t,method:"post",data:a})}var e=n(5108);const o={data:function(){return{modules:[],activeName:"appstore",commandDialogShow:!1,commandDialogFinish:!0,commandDialogTitle:"",commandDialogMsgs:[],commandDialogRunElapse:0}},mounted:function(){var t=this;this.doLoad(),setInterval((function(){t.commandDialogRunElapse=parseInt(((new Date).getTime()-t.commandDialogRunStart)/1e3)}),1e3)},methods:{handleClick:function(t,a){e.log(t,a)},doEnable:function(t){this.doCommand("enable",{module:t.name,version:t._localVersion},null,"启用模块 ".concat(t.title,"（").concat(t.name,"）"))},doDisable:function(t){this.doCommand("disable",{module:t.name},null,"禁用模块 ".concat(t.title,"（").concat(t.name,"）"))},doInstall:function(){var t="EditorImageCatchConfig",a="Blog简约主题",n="1.2.2";this.doCommand("install",{module:t},null,"安装模块 ".concat(a,"（").concat(t,"） V").concat(n))},doUninstall:function(t){var a=this;this.$confirm("确认卸载?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){a.doCommand("uninstall",{module:t.name,version:t._localVersion,isLocal:t._isLocal},null,"卸载模块 ".concat(t.title,"（").concat(t.name,"）"))})).catch((function(){a.$message({type:"info",message:"已取消卸载"})}))},doCommand:function(t,a,n,i){var o=this;i=i||null,null===(n=n||null)&&(this.commandDialogMsgs=[],this.commandDialogShow=!0,this.commandDialogFinish=!1),i&&(this.commandDialogTitle=i,this.commandDialogMsgs.push('<i class="el-icon-minus"></i> '+i)),this.commandDialogRunStart=(new Date).getTime(),this.commandDialogRunElapse=0,s(t,{token:this.storeApiToken,step:n,data:JSON.stringify(a)}).then((function(t){if(e.log(t,"res"),Array.isArray(t.data.msg)?o.commandDialogMsgs=o.commandDialogMsgs.concat(t.data.msg):o.commandDialogMsgs.push(t.data.msg),t.data.finish)return o.commandDialogFinish=!0,void o.doLoad();setTimeout((function(){o.doCommand(t.data.command,t.data.data,t.data.step)}),1e3)})).catch((function(t){return e.log(t),o.commandDialogMsgs.push('<i class="iconfont icon-close ub-text-danger"></i> <span class="ub-text-danger">'+t.msg+"</span>"),o.commandDialogFinish=!0,!0}))},doLoad:function(){var t=this;s("all",{}).then((function(a){t.modules=a.data.modules,e.log(a,"res")})).catch((function(t){e.log(t)}))}}};const l=(0,n(1900).Z)(o,(function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("div",{staticClass:"content_container",staticStyle:{margin:"5px"}},[n("div",{staticClass:"tabs"},[n("el-tabs",{on:{"tab-click":t.handleClick},model:{value:t.activeName,callback:function(a){t.activeName=a},expression:"activeName"}},[n("el-tab-pane",{attrs:{name:"appstore",label:"模块市场"}}),t._v(" "),n("el-tab-pane",{attrs:{name:"installed",label:"已安装"}}),t._v(" "),n("el-tab-pane",{attrs:{name:"enabled",label:"已启用"}}),t._v(" "),n("el-tab-pane",{attrs:{name:"disabled",label:"已禁用"}})],1)],1),t._v(" "),n("div",{staticClass:"app_store_black"},[n("el-row",{attrs:{gutter:20}},t._l(t.modules,(function(a,i){return n("el-col",{key:a.id,attrs:{span:7}},[n("div",{staticClass:"grid-content bg-purple"},[n("el-card",{staticClass:"box-card"},[n("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},[n("span",[t._v(t._s(a.title))])]),t._v(" "),n("el-row",{attrs:{gutter:5}},[n("el-col",{attrs:{span:6}},[n("div",{staticClass:"card_item_img"},[n("img",{staticClass:"image",attrs:{src:a.cover}})])]),t._v(" "),n("el-col",{attrs:{span:18}},[n("div",[n("div",[n("span",{staticClass:"red p-5"},[t._v(t._s(a.priceSuper?"￥"+a.priceSuper:"免费"))])]),t._v(" "),n("div",{staticClass:"desc d6 p-5"},[t._v(t._s(a.description))]),t._v(" "),n("div",{staticClass:"desc d6 p-5"},[t._v("版本：V"+t._s(a.latestVersion))])])])],1),t._v(" "),n("el-divider"),t._v(" "),a._isSystem?t._e():n("div",[a._isInstalled?t._e():n("div",[n("el-button",{attrs:{type:"text"},on:{click:function(a){return t.doInstall()}}},[t._v("安装")])],1),t._v(" "),a._isInstalled&&a._isEnabled?n("a",{staticStyle:{color:"red","margin-right":"15px"},attrs:{type:"text"},on:{click:function(n){return t.doDisable(a)}}},[t._v("\n                                禁用\n                            ")]):t._e(),t._v(" "),a._isInstalled&&!a._isEnabled?n("a",{staticStyle:{color:"green","margin-right":"15px"},attrs:{type:"text"},on:{click:function(n){return t.doEnable(a)}}},[t._v("\n                                启用\n                            ")]):t._e(),t._v(" "),a._isInstalled&&!a._isEnabled?n("a",{staticStyle:{color:"red","margin-right":"15px"},attrs:{type:"text"},on:{click:function(n){return t.doUninstall(a)}}},[t._v("\n                                卸载\n                            ")]):t._e()]),t._v(" "),n("el-divider"),t._v(" "),n("div",[n("el-button",{attrs:{type:"primary",icon:"el-icon-plus",plain:"",size:"mini"}},[t._v("其他版本")])],1)],1)],1)])})),1)],1),t._v(" "),n("el-dialog",{attrs:{visible:t.commandDialogShow,"show-close":t.commandDialogFinish,"close-on-press-escape":!1,"close-on-click-modal":!1,"append-to-body":""},on:{"update:visible":function(a){t.commandDialogShow=a}}},[n("div",{attrs:{slot:"title"},slot:"title"},[n("div",{staticClass:"ub-text-bold ub-text-primary"},[n("i",{staticClass:"el-icon-sort"}),t._v("\n                "+t._s(t.commandDialogTitle)+"\n            ")])]),t._v(" "),n("div",{staticClass:"dialog-block"},[t._l(t.commandDialogMsgs,(function(a,i){return n("div",{domProps:{innerHTML:t._s(a)}})})),t._v(" "),t.commandDialogFinish?n("div",[n("i",{staticClass:"el-icon-circle-check"}),t._v("\n                操作已运行完成\n            ")]):n("div",[n("i",{staticClass:"el-icon-loading"}),t._v("\n                当前操作已运行 "+t._s(t.commandDialogRunElapse)+" s ...\n            ")])],2),t._v(" "),t.commandDialogFinish?n("div",{staticClass:"dialog_footer"},[n("el-button",{attrs:{type:"danger",size:"mini"},on:{click:function(a){t.commandDialogShow=!1}}},[t._v("关闭")])],1):t._e()])],1)}),[],!1,null,null,null).exports}}]);