<template>
    <div class="tinymce-editor">
        <editor
            v-model="myValue"
            :init="init"
            :disabled="disabled"
            @onClick="onClick"
        >
        </editor>
    </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue"
import tinymce from "../../../../asset/vendor/tinymce/tinymce.min.js"
import "../../../../asset/vendor/tinymce/themes/silver/theme"
import "../../../../asset/vendor/tinymce/icons/default/icons"
import {getToken} from '../../utils/auth'
import {getBaseHost, getBaseApi} from '../../utils/index'

export default {
    components: {
        Editor,
    },
    props: {
        value: {
            type: String,
            default: "",
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        const token = getToken();
        return {
            //初始化配置
            init: {
                base_url: "../../../../asset/vendor/tinymce",
                external_plugins: {
                    link: "../../../../asset/vendor/tinymce/plugins/link/plugin.min.js",
                    emoticons: "../../../../asset/vendor/tinymce/plugins/emoticons/plugin.min.js",
                    insertdatetime: "../../../../asset/vendor/tinymce/plugins/insertdatetime/plugin.min.js",
                    preview: "../../../../asset/vendor/tinymce/plugins/preview/plugin.min.js",
                    code: "../../../../asset/vendor/tinymce/plugins/code/plugin.min.js",
                },
                language_url: "../../../../asset/vendor/tinymce/langs/zh_CN.js",
                language: "zh_CN",
                skin_url: "../../../../asset/vendor/tinymce/skins/ui/oxide",
                height: 200,
                toolbar:
                    "code bold italic link media emoticons insertdatetime preview removeformat",
                branding: false,
                convert_urls: false,
                menubar: false,
                //此处为图片上传处理函数，这个直接用了base64的图片形式上传图片，
                //如需ajax上传可参考https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_handler
                images_upload_handler: function (blobInfo, succFun, failFun) {
                    var xhr, formData;
                    var file = blobInfo.blob(); //转化为易于理解的file对象
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open("POST", getBaseApi()+'/blog/file/upload');
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                    xhr.setRequestHeader("sitedomain", localStorage.getItem("sitedomain"));
                    xhr.onload = function () {
                        var json;
                        json = JSON.parse(xhr.responseText);
                        succFun(getBaseHost() + json.data.path);
                    };
                    formData = new FormData();
                    formData.append("file", file, file.name);
                    formData.append("module", "article");
                    xhr.send(formData);
                },
                file_picker_callback(cb, value, meta) {
                    //当点击meidia图标上传时,判断meta.filetype == 'media'有必要，因为file_picker_callback是media(媒体)、image(图片)、file(文件)的共同入口
                    if (meta.filetype == "media") {
                        //创建一个隐藏的type=file的文件选择input
                        let input = document.createElement("input");
                        input.setAttribute("type", "file");
                        input.onchange = function () {
                            let file = this.files[0]; //只选取第一个文件。如果要选取全部，后面注意做修改
                            let xhr, formData;
                            xhr = new XMLHttpRequest();
                            xhr.open("POST", getBaseApi()+'/blog/file/upload');
                            xhr.setRequestHeader("Authorization", "Bearer " + token);
                            xhr.setRequestHeader("sitedomain", localStorage.getItem("sitedomain"));
                            xhr.withCredentials = self.credentials;
                            xhr.upload.onprogress = function () {
                                // 进度(e.loaded / e.total * 100)
                            };
                            xhr.onerror = function () {
                                //根据自己的需要添加代码
                                console.log(xhr.status);
                                return;
                            };
                            xhr.onload = function () {
                                let json = JSON.parse(xhr.responseText);
                                if (json.code == 200) {
                                    if (meta.filetype == "media") {
                                        cb(getBaseHost() + json.data.path, {
                                            text: json.data.name,
                                        });
                                    }
                                    if (meta.filetype == "image") {
                                        cb(getBaseHost() + json.data.path, {
                                            text: json.data.name,
                                        });
                                    }
                                    if (meta.filetype == "file") {
                                        cb(getBaseHost() + json.data.path, {
                                            text: json.data.name,
                                        });
                                    }
                                    return;
                                }
                            };
                            formData = new FormData();
                            formData.append("file", file, file.name);
                            formData.append("module", "article");
                            //正式使用将下面被注释的内容恢复
                            xhr.send(formData);
                        };
                        //触发点击
                        input.click();
                    }
                },
            },
            myValue: this.value,
        };
    },
    mounted() {
        tinymce.init({});
    },
    methods: {
        //添加相关的事件，可用的事件参照文档=> https://github.com/tinymce/tinymce-vue => All available events
        //需要什么事件可以自己增加
        onClick(e) {
            this.$emit("onClick", e, tinymce);
        },
        //可以添加一些自己的自定义事件，如清空内容
        clear() {
            this.myValue = "";
        },
    },
    watch: {
        value(newValue) {
            this.myValue = newValue;
        },
        myValue(newValue) {
            this.$emit("input", newValue);
        },
    },
};
</script>
<style scoped></style>
