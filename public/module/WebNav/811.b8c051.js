"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[811,893],{6530:(t,e,a)=>{a.d(e,{W3:()=>i,Ue:()=>o,$Z:()=>l,Vx:()=>n});var r=a(4319);function i(t){return(0,r.Z)({url:"/WebNav/category",method:"get",params:t})}function o(t){return(0,r.Z)({url:"/WebNav/category",method:"post",data:t})}function l(t){return(0,r.Z)({url:"/WebNav/category/"+t,method:"get"})}function n(t,e){return(0,r.Z)({url:"/WebNav/category/"+t,method:"put",data:e})}},3893:(t,e,a)=>{a.r(e),a.d(e,{default:()=>s});var r=a(4319);var i=a(113),o=a(1203),l=a(6530);const n={props:{category_id:{type:Number,default:""}},data:function(){return{headers:{},action:"",uploadData:{},createNavigationVisible:!1,updateNavigationVisible:!1,navigation_options:[],loading:!1,tableData:[],createLoading:!1,updateLoading:!1,createError:{},updateError:{},imageUrlPreview:"",editImageUrlPreview:"",category_options:[],createNavigationForm:{name:"",url:"",category_id:"",image_path:"",description:"",published:!0,sort:0,target:"_blank"},updateNavigationForm:{id:"",name:"",url:"",category_id:"",image_path:"",description:"",target:"_blank",published:"",sort:""}}},watch:{category_id:function(){this.getNavigation()}},mounted:function(){this.setAction(),this.setHeader(),this.getCategory(),this.getNavigation()},methods:{updateNavigation:function(t){var e=this;this.updateError={},this.updateLoading=!0;var a,i,o=this.updateNavigationForm.category_id;o instanceof Array&&(this.updateNavigationForm.category_id=o.slice(-1)[0]),(a=this.updateNavigationForm.id,i=this.updateNavigationForm,(0,r.Z)({url:"/WebNav/navigation/"+a,method:"put",data:i})).then((function(a){e.$message({message:a.message,type:"success"}),e.updateNavigationVisible=!1,e.getNavigation(),e.resetCreateForm(t)})).catch((function(t){var a=t.data;422===t.code&&(e.updateError=a)})).finally((function(){e.updateLoading=!1}))},handleEdit:function(t){var e,a=this;this.updateError={},(e=t.id,(0,r.Z)({url:"/WebNav/navigation/"+e,method:"get"})).then((function(t){var e=t.data;a.updateNavigationVisible=!0,a.updateNavigationForm=e;var r;r=a.parentData([],e.category_id,a.category_options),a.updateNavigationForm.category_id=0==r.length?[0]:r,a.updateLoading=!1,a.editImageUrlPreview=(0,o.UO)()+e.image_path}))},handleRemove:function(t){var e=this;this.$confirm("确定要删除么？","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){var a;(a=t.id,(0,r.Z)({url:"/WebNav/navigation/"+a,method:"delete"})).then((function(){e.$message({type:"success",message:"删除成功!"}),e.getNavigation()})).catch((function(t){var a=t.response.data;200!==a.code&&e.$message({type:"info",message:a.message})}))})).catch((function(){e.$message({type:"info",message:"取消删除"})}))},parentData:function(t,e,a){var r=this;return a.forEach((function(a){e==a.id?0!=e&&(t.unshift(a.id),r.parentData(t,a.parent_id,r.category_options)):a.children instanceof Array&&r.parentData(t,e,a.children)})),t},setHeader:function(){this.headers={Authorization:"Bearer "+(0,i.LP)()}},setAction:function(){this.action=(0,o.Vy)()+"/WebNav/file/upload"},successUpload:function(t,e,a){this.imageUrlPreview=(0,o.UO)()+t.data.path,this.createNavigationForm.image_path=t.data.path},beforeUpload:function(t){this.uploadData.directory="/navigation",this.uploadData.name=t.name},successUploadEdit:function(t,e,a){this.editImageUrlPreview="",this.editImageUrlPreview=(0,o.UO)()+t.data.path,this.updateNavigationForm.image_path=t.data.path},beforeUploadEdit:function(t){this.uploadData.directory="/navigation",this.uploadData.name=t.name},resetCreateForm:function(t){this.$refs[t].resetFields()},createNavigation:function(t){var e=this;this.createLoading=!0,this.createError={};var a,i=this.createNavigationForm.category_id;i instanceof Array&&(this.createNavigationForm.category_id=i.slice(-1)[0]),(a=this.createNavigationForm,(0,r.Z)({url:"/WebNav/navigation",method:"post",data:a})).then((function(a){e.$message({message:a.message,type:"success"}),e.resetCreateForm(t),e.getNavigation(),e.createNavigationVisible=!1})).catch((function(t){var a=t.data;422===t.code&&(e.createError=a)})).finally((function(){e.createLoading=!1}))},getNavigation:function(){var t=this;this.loading=!0,this.createNavigationForm.category_id=this.category_id;var e,a={category_id:this.category_id};(e=a,(0,r.Z)({url:"/WebNav/navigation",method:"get",params:e})).then((function(e){var a=e.data;t.loading=!1,t.tableData=JSON.parse(JSON.stringify(a.navigation)),t.navigation_options=JSON.parse(JSON.stringify(a.navigation)),t.navigation_options.unshift({id:0,name:"顶级导航"})})).catch((function(e){t.loading=!1,t.tableData=[],t.total=0}))},getCategory:function(){var t=this;this.loading=!0;(0,l.W3)({}).then((function(e){var a=e.data;t.loading=!1,t.category_options=a.category})).catch((function(e){t.loading=!1,t.tableData=[],t.total=0}))}}};const s=(0,a(1900).Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-button",{attrs:{size:"small",type:"primary"},on:{click:function(e){t.createNavigationVisible=!0}}},[a("i",{staticClass:"el-icon-plus"}),t._v(" 添加导航\n    ")]),t._v(" "),a("div",{staticClass:"material_list",staticStyle:{top:"50px"}},[a("el-scrollbar",[a("div",{staticClass:"scrollbar-table"},[a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],attrs:{data:t.tableData,"tooltip-effect":"dark"}},[a("el-table-column",{attrs:{prop:"name","show-overflow-tooltip":!0,"min-width":"15%",label:"名称",align:"left"}}),t._v(" "),a("el-table-column",{attrs:{prop:"url","show-overflow-tooltip":!0,"min-width":"15%",label:"地址",align:"left"}}),t._v(" "),a("el-table-column",{attrs:{prop:"published","show-overflow-tooltip":!0,"min-width":"15%",label:"是否发布"},scopedSlots:t._u([{key:"default",fn:function(e){return[1==e.row.published?a("el-tag",{staticStyle:{margin:"0 3px"},attrs:{type:"success",size:"small"}},[t._v("已发布\n                            ")]):a("el-tag",{staticStyle:{margin:"0 3px"},attrs:{type:"info",size:"small"}},[t._v("未发布")])]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"分类","show-overflow-tooltip":!0,"min-width":"15%",label:"类型"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-tag",{staticStyle:{margin:"0 3px"},attrs:{size:"small"}},[t._v("\n                                "+t._s(null!=e.row.category&&e.row.category.hasOwnProperty("name")?e.row.category.name:"无")+"\n                            ")])]}}])}),t._v(" "),a("el-table-column",{attrs:{align:"center",label:"操作",width:"80"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"text",title:"编辑"},on:{click:function(a){return t.handleEdit(e.row)}}},[a("i",{staticClass:"el-icon-edit"})]),t._v(" "),a("el-button",{attrs:{title:"删除",type:"text"},on:{click:function(a){return t.handleRemove(e.row)}}},[a("i",{staticClass:"el-icon-delete"})])]}}])})],1)],1)]),t._v(" "),a("el-dialog",{attrs:{"custom-class":"dialog_tc",title:"创建",visible:t.createNavigationVisible,width:"560px","close-on-click-modal":!1},on:{"update:visible":function(e){t.createNavigationVisible=e}}},[a("el-form",{ref:"createForm",attrs:{model:t.createNavigationForm,"label-width":"80px",size:"medium"}},[a("el-form-item",{attrs:{label:"所属分类",prop:"category_id",error:t.createError.category_id?t.createError.category_id[0]:""}},[a("el-cascader",{attrs:{options:t.category_options,clearable:"",filterable:"",props:{checkStrictly:!0,label:"name",value:"id",expandTrigger:"click"},placeholder:"请选择所属分类"},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.node,i=e.data;return[a("span",[t._v(t._s(i.name))]),t._v(" "),r.isLeaf?t._e():a("span",[t._v(" ("+t._s(i.children.length)+") ")])]}}]),model:{value:t.createNavigationForm.category_id,callback:function(e){t.$set(t.createNavigationForm,"category_id",e)},expression:"createNavigationForm.category_id"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"name",label:"导航名称",required:"",error:t.createError.name?t.createError.name[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"请输入导航名称"},model:{value:t.createNavigationForm.name,callback:function(e){t.$set(t.createNavigationForm,"name",e)},expression:"createNavigationForm.name"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"url",label:"导航网址",error:t.createError.url?t.createError.url[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"例：www.zealov.com"},model:{value:t.createNavigationForm.url,callback:function(e){t.$set(t.createNavigationForm,"url",e)},expression:"createNavigationForm.url"}})],1),t._v(" "),a("el-form-item",{staticClass:"upload_thumb",attrs:{label:"缩略图",prop:"image_path"}},[a("el-upload",{staticClass:"uploadThumbImg",attrs:{headers:t.headers,action:t.action,"show-file-list":!1,"on-success":t.successUpload,"before-upload":t.beforeUpload,data:t.uploadData}},[t.createNavigationForm.image_path?a("img",{staticClass:"thumb",attrs:{src:t.imageUrlPreview}}):a("i",{staticClass:"el-icon-plus"})]),t._v(" "),a("div",{staticClass:"el-upload__tip"},[t._v("\n                        支持JPG/PNG格式，建议尺寸800*450px或16:9\n                        "),a("br"),t._v("图片大小不超过1MB\n                    ")])],1),t._v(" "),a("el-form-item",{attrs:{prop:"description",label:"简介",error:t.createError.description?t.createError.description[0]:""}},[a("el-input",{attrs:{type:"textarea",placeholder:"请输入简介",maxlength:"500","show-word-limit":"",rows:3},model:{value:t.createNavigationForm.description,callback:function(e){t.$set(t.createNavigationForm,"description",e)},expression:"createNavigationForm.description"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"published",label:"状态",error:t.createError.published?t.createError.published[0]:""}},[a("el-switch",{attrs:{"active-value":"1","inactive-value":"0"},model:{value:t.createNavigationForm.published,callback:function(e){t.$set(t.createNavigationForm,"published",e)},expression:"createNavigationForm.published"}})],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.createNavigationVisible=!1}}},[t._v("取消")]),t._v(" "),a("el-button",{attrs:{type:"primary",loading:t.createLoading},on:{click:function(e){return t.createNavigation("createForm")}}},[t._v("保存")])],1)],1),t._v(" "),a("el-dialog",{attrs:{"custom-class":"dialog_tc",title:"修改",visible:t.updateNavigationVisible,width:"560px","close-on-click-modal":!1},on:{"update:visible":function(e){t.updateNavigationVisible=e}}},[a("el-form",{ref:"updateForm",attrs:{model:t.updateNavigationForm,"label-width":"80px",size:"medium"}},[a("el-form-item",{attrs:{label:"所属分类",prop:"category_id",error:t.updateError.category_id?t.updateError.category_id[0]:""}},[a("el-cascader",{attrs:{options:t.category_options,clearable:"",filterable:"",props:{checkStrictly:!0,label:"name",value:"id",expandTrigger:"click"},placeholder:"请选择所属分类"},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.node,i=e.data;return[a("span",[t._v(t._s(i.name))]),t._v(" "),r.isLeaf?t._e():a("span",[t._v(" ("+t._s(i.children.length)+") ")])]}}]),model:{value:t.updateNavigationForm.category_id,callback:function(e){t.$set(t.updateNavigationForm,"category_id",e)},expression:"updateNavigationForm.category_id"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"name",label:"导航名称",required:"",error:t.updateError.name?t.updateError.name[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"请输入导航名称"},model:{value:t.updateNavigationForm.name,callback:function(e){t.$set(t.updateNavigationForm,"name",e)},expression:"updateNavigationForm.name"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"url",label:"导航地址",error:t.updateError.url?t.updateError.url[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"请输入导航地址"},model:{value:t.updateNavigationForm.url,callback:function(e){t.$set(t.updateNavigationForm,"url",e)},expression:"updateNavigationForm.url"}})],1),t._v(" "),a("el-form-item",{staticClass:"upload_thumb",attrs:{label:"缩略图",prop:"image_path"}},[a("el-upload",{staticClass:"uploadThumbImg",attrs:{headers:t.headers,action:t.action,"show-file-list":!1,"on-success":t.successUploadEdit,"before-upload":t.beforeUploadEdit,data:t.uploadData}},[t.updateNavigationForm.image_path?a("img",{staticClass:"thumb",attrs:{src:t.editImageUrlPreview}}):a("i",{staticClass:"el-icon-plus"})]),t._v(" "),a("div",{staticClass:"el-upload__tip"},[t._v("\n                        支持JPG/PNG格式，建议尺寸800*450px或16:9\n                        "),a("br"),t._v("图片大小不超过1MB\n                    ")])],1),t._v(" "),a("el-form-item",{attrs:{prop:"description",label:"简介",error:t.updateError.description?t.updateError.description[0]:""}},[a("el-input",{attrs:{type:"textarea",placeholder:"请输入简介",maxlength:"500","show-word-limit":"",rows:3},model:{value:t.updateNavigationForm.description,callback:function(e){t.$set(t.updateNavigationForm,"description",e)},expression:"updateNavigationForm.description"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"target",label:"打开方式",error:t.updateError.target?t.updateError.target[0]:""}},[a("el-radio",{attrs:{label:"_self"},model:{value:t.updateNavigationForm.target,callback:function(e){t.$set(t.updateNavigationForm,"target",e)},expression:"updateNavigationForm.target"}},[t._v("当前窗口")]),t._v(" "),a("el-radio",{attrs:{label:"_blank"},model:{value:t.updateNavigationForm.target,callback:function(e){t.$set(t.updateNavigationForm,"target",e)},expression:"updateNavigationForm.target"}},[t._v("新建窗口")])],1),t._v(" "),a("el-form-item",{attrs:{prop:"published",label:"状态",error:t.updateError.published?t.updateError.published[0]:""}},[a("el-switch",{attrs:{"active-value":1,"inactive-value":0},model:{value:t.updateNavigationForm.published,callback:function(e){t.$set(t.updateNavigationForm,"published",e)},expression:"updateNavigationForm.published"}})],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.updateNavigationVisible=!1}}},[t._v("取消")]),t._v(" "),a("el-button",{attrs:{type:"primary",loading:t.updateLoading},on:{click:function(e){return t.updateNavigation("updateForm")}}},[t._v("保存")])],1)],1)],1)],1)}),[],!1,null,null,null).exports},7811:(t,e,a)=>{a.r(e),a.d(e,{default:()=>c});var r=a(3893),i=a(6530),o=a(1203),l=a(113),n=a(5108);const s={data:function(){return{updateCategoryVisible:!1,createCategoryVisible:!1,updateError:{},updateLoading:!1,loading:!1,createLoading:!1,createError:{},uploadData:{},headers:{},imageUrlPreview:"",editImageUrlPreview:"",action:"",tableData:[],category_options:[],category_id:"",createCategoryForm:{name:"",label:"",parent_id:[0],image_path:"",description:"",published:!0,sort:0},updateCategoryForm:{id:"",name:"",label:"",parent_id:"",image_path:"",description:"",published:"",sort:""}}},components:{NavigationTable:r.default},created:function(){this.setAction(),this.setHeader(),this.getCategory()},methods:{setCategory:function(t){this.category_id=t.id},createChildren:function(t){this.createCategoryVisible=!0;var e;e=this.parentData([],t.id,this.category_options),this.createCategoryForm.parent_id=0==e.length?[0]:e},updateCategory:function(){var t=this;this.updateError={},this.updateLoading=!0;var e=this.updateCategoryForm.parent_id;e instanceof Array&&(this.updateCategoryForm.parent_id=e.slice(-1)[0]),(0,i.Vx)(this.updateCategoryForm.id,this.updateCategoryForm).then((function(e){t.$message({message:e.message,type:"success"}),t.updateCategoryVisible=!1,t.getCategory(),t.$refs.child.getCategory()})).catch((function(e){var a=e.data;t.updateError=a})).finally((function(){t.updateLoading=!1}))},handleEdit:function(t){var e=this;this.updateError={},(0,i.$Z)(t.id).then((function(t){var a=t.data;e.updateCategoryVisible=!0,e.updateCategoryForm=a;var r;r=e.parentData([],a.parent_id,e.category_options),e.updateCategoryForm.parent_id=0==r.length?[0]:r,e.updateLoading=!1,e.editImageUrlPreview=(0,o.UO)()+a.image_path}))},parentData:function(t,e,a){var r=this;return a.forEach((function(a){e==a.id?0!=e&&(t.unshift(a.id),r.parentData(t,a.parent_id,r.category_options)):a.children instanceof Array&&r.parentData(t,e,a.children)})),t},createCategory:function(t){var e=this;this.createLoading=!0,this.createError={};var a=this.createCategoryForm.parent_id;a instanceof Array&&(this.createCategoryForm.parent_id=a.slice(-1)[0]),(0,i.Ue)(this.createCategoryForm).then((function(a){e.$message({message:a.message,type:"success"}),e.resetCreateForm(t),e.getCategory(),e.createCategoryVisible=!1,e.$refs.child.getCategory()})).catch((function(t){var a=t.data;e.createError=a})).finally((function(){e.createLoading=!1}))},getCategory:function(){var t=this;this.loading=!0;(0,i.W3)({}).then((function(e){var a=e.data;t.loading=!1,t.tableData=JSON.parse(JSON.stringify(a.category)),t.category_options=JSON.parse(JSON.stringify(a.category)),t.category_options.unshift({id:0,name:"顶级分类"}),t.tableData.unshift({name:"全部分类"})})).catch((function(e){t.loading=!1,t.tableData=[],t.total=0}))},setAction:function(){this.action=(0,o.Vy)()+"/WebNav/file/upload"},setHeader:function(){this.headers={Authorization:"Bearer "+(0,l.LP)()}},successUpload:function(t,e,a){this.imageUrlPreview=(0,o.UO)()+t.data.path,this.createCategoryForm.image_path=t.data.path},beforeUpload:function(t){this.uploadData.directory="/system_file",this.uploadData.name=t.name},successUploadEdit:function(t,e,a){this.editImageUrlPreview=(0,o.UO)()+t.data.path,n.log(this.editImageUrlPreview),this.updateCategoryForm.image_path=t.data.path,n.log(this.updateCategoryForm)},beforeUploadEdit:function(t){this.uploadData.directory="/system_file",this.uploadData.name=t.name},resetCreateForm:function(t){this.$refs[t].resetFields()}}};const c=(0,a(1900).Z)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"content_container"},[a("div",{staticClass:"container material-box",staticStyle:{"padding-top":"0","padding-bottom":"0"}},[a("div",{staticClass:"material-content",staticStyle:{top:"20px"}},[a("div",{staticClass:"material-left"},[a("div",{staticClass:"material-group"},[a("div",{staticClass:"top",staticStyle:{"background-color":"#f0f0f0","padding-bottom":"15px"}},[a("div",{staticClass:"title",on:{click:function(e){t.category_id=""}}},[t._v("分类")]),t._v(" "),a("el-button",{attrs:{type:"text"},on:{click:function(e){t.createCategoryVisible=!0}}},[a("i",{staticClass:"el-icon-circle-plus-outline"})])],1),t._v(" "),a("div",{staticClass:"group-tree"},[a("el-scrollbar",[a("el-tree",{attrs:{data:t.tableData,"node-key":"id","default-expand-all":"","expand-on-click-node":!1,"highlight-current":!0},scopedSlots:t._u([{key:"default",fn:function(e){e.node;var r=e.data;return a("span",{staticClass:"custom-tree-node",on:{click:function(e){return t.setCategory(r)}}},[a("el-tooltip",{staticClass:"item",attrs:{effect:"light",placement:"top-start",disabled:!0}},[a("span",{staticClass:"node-name"},[t._v(t._s(r.name))])]),t._v(" "),"全部分类"!=r.name?a("span",{staticClass:"button"},[a("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(e){return t.handleEdit(r)}}},[a("i",{staticClass:"el-icon-edit"})]),t._v(" "),a("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(e){return t.createChildren(r)}}},[a("i",{staticClass:"el-icon-circle-plus-outline"})])],1):t._e()],1)}}])})],1)],1)])]),t._v(" "),a("div",{staticClass:"material-right"},[a("NavigationTable",{ref:"child",attrs:{category_id:t.category_id}})],1)])]),t._v(" "),a("el-dialog",{attrs:{"custom-class":"dialog_tc",title:"添加分类",visible:t.createCategoryVisible,width:"560px","close-on-click-modal":!1},on:{"update:visible":function(e){t.createCategoryVisible=e}}},[a("el-form",{ref:"createForm",attrs:{model:t.createCategoryForm,"label-width":"80px",size:"medium"}},[a("el-form-item",{attrs:{label:"上级分类",prop:"parent_id",error:t.createError.parent_id?t.createError.parent_id[0]:""}},[a("el-cascader",{attrs:{options:t.category_options,clearable:"",filterable:"",props:{checkStrictly:!0,label:"name",value:"id",expandTrigger:"click"},placeholder:"请选择上级分类"},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.node,i=e.data;return[a("span",[t._v(t._s(i.name))]),t._v(" "),r.isLeaf?t._e():a("span",[t._v(" ("+t._s(i.children.length)+") ")])]}}]),model:{value:t.createCategoryForm.parent_id,callback:function(e){t.$set(t.createCategoryForm,"parent_id",e)},expression:"createCategoryForm.parent_id"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"name",label:"分类名称",required:"",error:t.createError.name?t.createError.name[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"请输入分类名称"},model:{value:t.createCategoryForm.name,callback:function(e){t.$set(t.createCategoryForm,"name",e)},expression:"createCategoryForm.name"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"label",label:"分类标识",required:"",error:t.createError.label?t.createError.label[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"限英文字母,设定后不可修改"},model:{value:t.createCategoryForm.label,callback:function(e){t.$set(t.createCategoryForm,"label",e)},expression:"createCategoryForm.label"}})],1),t._v(" "),a("el-form-item",{staticClass:"upload_thumb",attrs:{label:"缩略图",prop:"thumbnail"}},[a("el-upload",{staticClass:"uploadThumbImg",attrs:{headers:t.headers,action:t.action,"show-file-list":!1,"on-success":t.successUpload,"before-upload":t.beforeUpload,data:t.uploadData}},[t.createCategoryForm.image_path?a("img",{staticClass:"thumb",attrs:{src:t.imageUrlPreview}}):a("i",{staticClass:"el-icon-plus"})]),t._v(" "),a("div",{staticClass:"el-upload__tip"},[t._v("\n                    支持JPG/PNG格式，建议尺寸800*450px或16:9\n                    "),a("br"),t._v("图片大小不超过1MB\n                ")])],1),t._v(" "),a("el-form-item",{attrs:{prop:"description",label:"简介",error:t.createError.description?t.createError.description[0]:""}},[a("el-input",{attrs:{type:"textarea",placeholder:"请输入简介",maxlength:"500","show-word-limit":"",rows:3},model:{value:t.createCategoryForm.description,callback:function(e){t.$set(t.createCategoryForm,"description",e)},expression:"createCategoryForm.description"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"published",label:"状态",error:t.createError.published?t.createError.published[0]:""}},[a("el-switch",{attrs:{"active-value":"1","inactive-value":"0"},model:{value:t.createCategoryForm.published,callback:function(e){t.$set(t.createCategoryForm,"published",e)},expression:"createCategoryForm.published"}})],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.createCategoryVisible=!1}}},[t._v("取消")]),t._v(" "),a("el-button",{attrs:{type:"primary",loading:t.createLoading},on:{click:function(e){return t.createCategory("createForm")}}},[t._v("确定")])],1)],1),t._v(" "),a("el-dialog",{attrs:{"custom-class":"dialog_tc",title:"修改分类",visible:t.updateCategoryVisible,width:"560px","close-on-click-modal":!1},on:{"update:visible":function(e){t.updateCategoryVisible=e}}},[a("el-form",{ref:"updateForm",attrs:{model:t.updateCategoryForm,"label-width":"80px",size:"medium"}},[a("el-form-item",{attrs:{label:"上级分类",prop:"parent_id",error:t.updateError.parent_id?t.updateError.parent_id[0]:""}},[a("el-cascader",{attrs:{options:t.category_options,clearable:"",filterable:"",props:{checkStrictly:!0,label:"name",value:"id",expandTrigger:"click"},placeholder:"请选择上级分类"},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.node,i=e.data;return[a("span",[t._v(t._s(i.name))]),t._v(" "),r.isLeaf?t._e():a("span",[t._v(" ("+t._s(i.children.length)+") ")])]}}]),model:{value:t.updateCategoryForm.parent_id,callback:function(e){t.$set(t.updateCategoryForm,"parent_id",e)},expression:"updateCategoryForm.parent_id"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"name",label:"分类名称",required:"",error:t.updateError.name?t.updateError.name[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"请输入分类名称"},model:{value:t.updateCategoryForm.name,callback:function(e){t.$set(t.updateCategoryForm,"name",e)},expression:"updateCategoryForm.name"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"label",label:"分类标识",required:"",error:t.updateError.label?t.updateError.label[0]:""}},[a("el-input",{attrs:{type:"text",placeholder:"限英文字母,设定后不可修改"},model:{value:t.updateCategoryForm.label,callback:function(e){t.$set(t.updateCategoryForm,"label",e)},expression:"updateCategoryForm.label"}})],1),t._v(" "),a("el-form-item",{staticClass:"upload_thumb",attrs:{label:"缩略图",prop:"thumbnail"}},[a("el-upload",{staticClass:"uploadThumbImg",attrs:{headers:t.headers,action:t.action,"show-file-list":!1,"on-success":t.successUploadEdit,"before-upload":t.beforeUploadEdit,data:t.uploadData}},[t.updateCategoryForm.image_path?a("img",{staticClass:"thumb",attrs:{src:t.editImageUrlPreview}}):a("i",{staticClass:"el-icon-plus"})]),t._v(" "),a("div",{staticClass:"el-upload__tip"},[t._v("\n                    支持JPG/PNG格式，建议尺寸800*450px或16:9\n                    "),a("br"),t._v("图片大小不超过1MB\n                ")])],1),t._v(" "),a("el-form-item",{attrs:{prop:"description",label:"简介",error:t.updateError.description?t.updateError.description[0]:""}},[a("el-input",{attrs:{type:"textarea",placeholder:"请输入简介",maxlength:"500","show-word-limit":"",rows:3},model:{value:t.updateCategoryForm.description,callback:function(e){t.$set(t.updateCategoryForm,"description",e)},expression:"updateCategoryForm.description"}})],1),t._v(" "),a("el-form-item",{attrs:{prop:"published",label:"状态",error:t.updateError.published?t.updateError.published[0]:""}},[a("el-switch",{attrs:{"active-value":1,"inactive-value":0},model:{value:t.updateCategoryForm.published,callback:function(e){t.$set(t.updateCategoryForm,"published",e)},expression:"updateCategoryForm.published"}})],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.updateCategoryVisible=!1}}},[t._v("取消")]),t._v(" "),a("el-button",{attrs:{type:"primary",loading:t.updateLoading},on:{click:function(e){return t.updateCategory("updateForm")}}},[t._v("修改")])],1)],1)],1)}),[],!1,null,null,null).exports}}]);