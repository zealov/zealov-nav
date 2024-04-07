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

import { Loading } from "element-ui";
import {getToken} from '../../utils/auth'
import {getBaseHost, getBaseApi} from '../../utils/index'
var action = '';
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
        action:{
            type: String,
            default: "",
        }
    },
    data() {
        const token = getToken();
        return {
            //初始化配置
            init: {
                base_url: "../../../../asset/vendor/tinymce",
                fontsize_formats: "12px 14px 16px 18px 20px 22px 24px 26px 28px 30px",
                external_plugins: {
                    anchor: "../../../../asset/vendor/tinymce/plugins/anchor/plugin.min.js",
                    code: "../../../../asset/vendor/tinymce/plugins/code/plugin.min.js",
                    print: "../../../../asset/vendor/tinymce/plugins/print/plugin.min.js",
                    preview: "../../../../asset/vendor/tinymce/plugins/preview/plugin.min.js",
                    searchreplace: "../../../../asset/vendor/tinymce/plugins/searchreplace/plugin.min.js",
                    autolink: "../../../../asset/vendor/tinymce/plugins/autolink/plugin.min.js",
                    directionality: "../../../../asset/vendor/tinymce/plugins/directionality/plugin.min.js",
                    visualblocks: "../../../../asset/vendor/tinymce/plugins/visualblocks/plugin.min.js",
                    visualchars: "../../../../asset/vendor/tinymce/plugins/visualchars/plugin.min.js",
                    fullscreen: "../../../../asset/vendor/tinymce/plugins/fullscreen/plugin.min.js",
                    image: "../../../../asset/vendor/tinymce/plugins/image/plugin.min.js",
                    // axupimgs: "../../../../asset/vendor/tinymce/plugins/axupimgs/plugin.min.js",
                    link: "../../../../asset/vendor/tinymce/plugins/link/plugin.min.js",
                    media: "../../../../asset/vendor/tinymce/plugins/media/plugin.min.js",
                    template: "../../../../asset/vendor/tinymce/plugins/template/plugin.min.js",
                    codesample: "../../../../asset/vendor/tinymce/plugins/codesample/plugin.min.js",
                    table: "../../../../asset/vendor/tinymce/plugins/table/plugin.min.js",
                    charmap: "../../../../asset/vendor/tinymce/plugins/charmap/plugin.min.js",
                    pagebreak: "../../../../asset/vendor/tinymce/plugins/pagebreak/plugin.min.js",
                    nonbreaking: "../../../../asset/vendor/tinymce/plugins/nonbreaking/plugin.min.js",
                    insertdatetime: "../../../../asset/vendor/tinymce/plugins/insertdatetime/plugin.min.js",
                    advlist: "../../../../asset/vendor/tinymce/plugins/advlist/plugin.min.js",
                    lists: "../../../../asset/vendor/tinymce/plugins/lists/plugin.min.js",
                    wordcount: "../../../../asset/vendor/tinymce/plugins/wordcount/plugin.min.js",
                    imagetools: "../../../../asset/vendor/tinymce/plugins/imagetools/plugin.min.js",
                    textpattern: "../../../../asset/vendor/tinymce/plugins/textpattern/plugin.min.js",
                    help: "../../../../asset/vendor/tinymce/plugins/help/plugin.min.js",
                    emoticons: "../../../../asset/vendor/tinymce/plugins/emoticons/plugin.min.js",
                    autosave: "../../../../asset/vendor/tinymce/plugins/autosave/plugin.min.js",
                    iframe: "../../../../asset/vendor/tinymce/plugins/iframe/plugin.min.js",
                    // wechat: "../../../../asset/vendor/tinymce/plugins/wechat/plugin.min.js",
                    hr: "../../../../asset/vendor/tinymce/plugins/hr/plugin.min.js",
                    indent2em: "../../../../asset/vendor/tinymce/plugins/indent2em/plugin.min.js",
                },
                language_url: "../../../../asset/vendor/tinymce/langs/zh_CN.js",
                language: "zh_CN",
                skin_url: "../../../../asset/vendor/tinymce/skins/ui/oxide",
                font_formats:
                    "微软雅黑=Microsoft YaHei,Helvetica Neue,PingFang SC,sans-serif;苹果苹方=PingFang SC,Microsoft YaHei,sans-serif;宋体=simsun,serif;仿宋体=FangSong,serif;黑体=SimHei,sans-serif;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;",
                height: 700, //编辑器高度
                min_height: 200,
                max_height: 700,
                toolbar:
                    "template code undo redo restoredraft cut copy paste pastetext forecolor backcolor bold italic underline strikethrough link unlink anchor alignleft aligncenter alignright alignjustify outdent indent formatselect fontsizeselect bullist numlist blockquote subscript superscript removeformat table image axupimgs media charmap emoticons pagebreak insertdatetime print preview fullscreen formatpainter iframe hr wechat indent2em",
                branding: false,
                relative_urls: false, //停用附件路径自动修订
                remove_script_host: true, //停用附件路径自动修订
                paste_data_images: true, // 允许粘贴图像
                file_picker_types: "file image media",
                //此处为图片上传处理函数，这个直接用了base64的图片形式上传图片，
                //如需ajax上传可参考https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_handler
                images_upload_handler: function (blobInfo, succFun, failFun) {
                    var xhr, formData;
                    var file = blobInfo.blob(); //转化为易于理解的file对象
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open("POST", action);
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
                media_url_resolver: function(data, resolve) {
                    try {
                        let videoUri = encodeURI(data.url);
                        let embedHtml = `<p>
                  <span
                    class="mce-object mce-object-video"
                    data-mce-selected="1"
                    data-mce-object="video"
                    data-mce-p-width="100%"
                    data-mce-p-height="auto"
                    data-mce-p-controls="controls"
                    data-mce-p-controlslist="nodownload"
                    data-mce-p-allowfullscreen="true"
                    data-mce-p-src=${videoUri} >
                    <video src=${data.url} width="100%" height="auto" controls="controls" controlslist="nodownload">
                    </video>
                  </span>
                </p>
                <p style="text-align: left;"></p>`;
                        resolve({ html: embedHtml });
                    } catch (e) {
                        resolve({ html: "" });
                    }
                },
                file_picker_callback(cb, value, meta) {
                    //一类上传完的反馈过程
                    //当点击meidia图标上传时,判断meta.filetype == 'media'有必要，因为file_picker_callback是media(媒体)、image(图片)、file(文件)的共同入口
                    console.log("meta", meta);

                    //创建一个隐藏的type=file的文件选择input
                    let input = document.createElement("input");
                    input.setAttribute("type", "file");
                    input.onchange = function() {
                        var loadingInstance1 = Loading.service({ fullscreen: true });
                        var xhr, formData;
                        let file = this.files[0]; //只选取第一个文件。如果要选取全部，后面注意做修改
                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open("POST", action);
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                        xhr.onload = function() {
                            var json;
                            json = JSON.parse(xhr.responseText);
                        };
                        formData = new FormData();
                        formData.append("file", file, file.name);
                        formData.append("module", "article");
                        xhr.send(formData);

                        xhr.upload.onprogress = function() {
                            // 进度(e.loaded / e.total * 100)
                            progress((e.loaded / e.total) * 100);
                        };
                        // xhr.onerror = function () {
                        //   //根据自己的需要添加代码
                        //   console.log(xhr.status);
                        //   return;
                        // };
                        xhr.onload = function() {
                            let json = JSON.parse(xhr.responseText);
                            console.log(json);
                            if (json.code == 200) {
                                loadingInstance1.close();
                                if (meta.filetype == "media") {
                                    cb(getBaseHost()  + json.data.path, {
                                        text: json.data.name,
                                    });
                                }
                                if (meta.filetype == "image") {
                                    cb(getBaseHost()  + json.data.path, {
                                        text: json.data.name,
                                    });
                                }
                                if (meta.filetype == "file") {
                                    cb(getBaseHost()  + json.data.path, {
                                        text: json.data.name,
                                    });
                                }
                                return;
                            }
                        };
                    };
                    //触发点击
                    input.click();
                },
            },
            myValue: this.value,
            laws: [],
            reFresh: false,
        };
    },
    mounted() {
        tinymce.init({});
        console.log(this.action,'asd')
        action = this.action
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
        "init.templates"(newValue) {
            // this.$set(this.init, "templates", JSON.parse(JSON.stringify(newValue)));
            this.reFresh = false;
            this.$nextTick(() => {
                this.reFresh = true;
            });
        },
    },
};
</script>
<style scoped></style>
