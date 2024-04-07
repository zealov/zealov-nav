<template>
    <div>
        <el-button
            size="small"
            type="primary"
            @click="createNavigationVisible = true"
        >
            <i class="el-icon-plus"/> 添加导航
        </el-button>

        <div class="material_list" style="top: 50px">
            <el-scrollbar>
                <div class="scrollbar-table">
                    <el-table :data="tableData" v-loading="loading" tooltip-effect="dark">
                        <el-table-column
                            prop="name"
                            :show-overflow-tooltip="true"
                            min-width="15%"
                            label="名称"
                            align="left"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="url"
                            :show-overflow-tooltip="true"
                            min-width="15%"
                            label="地址"
                            align="left"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="published"
                            :show-overflow-tooltip="true"
                            min-width="15%"
                            label="是否发布"
                        >
                            <template slot-scope="scope">
                                <el-tag
                                    v-if="scope.row.published == 1"
                                    type="success"
                                    size="small"
                                    style="margin: 0 3px"
                                >已发布
                                </el-tag>
                                <el-tag v-else type="info" size="small" style="margin: 0 3px">未发布</el-tag>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="分类"
                            :show-overflow-tooltip="true"
                            min-width="15%"
                            label="类型"
                        >
                            <template slot-scope="scope">
                                <el-tag
                                    size="small"
                                    style="margin: 0 3px"
                                >
                                    {{ (scope.row.category != null && scope.row.category.hasOwnProperty('name')) ? scope.row.category.name : '无' }}
                                </el-tag>

                            </template>
                        </el-table-column>
                        <el-table-column align="center" label="操作" width="80">
                            <template slot-scope="scope">
                                <el-button
                                    type="text"
                                    title="编辑"
                                    @click="handleEdit(scope.row)"
                                ><i class="el-icon-edit"></i
                                ></el-button>
                                <el-button
                                    title="删除"
                                    type="text"
                                    @click="handleRemove(scope.row)"
                                >
                                    <i class="el-icon-delete"></i>
                                </el-button>

                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </el-scrollbar>
            <!-- 添加导航 -->
            <el-dialog
                custom-class="dialog_tc"
                title="添加导航"
                :visible.sync="createNavigationVisible"
                width="560px"
                :close-on-click-modal="false"
            >
                <el-form
                    ref="createForm"
                    :model="createNavigationForm"
                    label-width="80px"
                    size="medium"
                >
                    <el-form-item
                        label="所属分类"
                        prop="category_id"
                        :error="createError.category_id ? createError.category_id[0] : ''"
                    >
                        <el-cascader
                            v-model="createNavigationForm.category_id"
                            :options="category_options"
                            clearable
                            filterable
                            :props="{
                              checkStrictly: true,
                              label: 'name',
                              value: 'id',
                              expandTrigger: 'click',
                            }"
                            placeholder="请选择所属分类"
                        >
                            <template slot-scope="{ node, data }">
                                <span>{{ data.name }}</span>
                                <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
                            </template>
                        </el-cascader>
                    </el-form-item>
                    <el-form-item
                        prop="name"
                        label="导航名称"
                        required
                        :error="createError.name ? createError.name[0] : ''"
                    >
                        <el-input
                            type="text"
                            placeholder="请输入导航名称"
                            v-model="createNavigationForm.name"
                        ></el-input>
                    </el-form-item>

                    <el-form-item
                        prop="url"
                        label="导航网址"
                        :error="createError.url ? createError.url[0] : ''"
                    >
                        <el-input
                            type="text"
                            placeholder="例：www.zealov.com"
                            v-model="createNavigationForm.url"
                        ></el-input>
                    </el-form-item>
                    <el-form-item
                        label="缩略图"
                        class="upload_thumb"
                        prop="image_path"
                        :error="createError.file ? createError.file[0] : ''"
                    >
                        <el-upload
                            class="uploadThumbImg"
                            :headers="headers"
                            :action="action"
                            :show-file-list="false"
                            :on-success="successUpload"
                            :before-upload="beforeUpload"
                            :on-error="errorUpload"
                            :data="uploadData"
                        >
                            <img
                                v-if="createNavigationForm.image_path"
                                :src="imageUrlPreview"
                                class="thumb"
                            />
                            <i v-else class="el-icon-plus"></i>
                        </el-upload>
                        <div class="el-upload__tip">
                            支持JPG/PNG格式，建议尺寸800*450px或16:9
                            <br/>图片大小不超过1MB
                        </div>
                    </el-form-item>

                    <el-form-item
                        prop="description"
                        label="简介"
                        :error="createError.description ? createError.description[0] : ''"
                    >
                        <el-input
                            type="textarea"
                            v-model="createNavigationForm.description"
                            placeholder="请输入简介"
                            maxlength="500"
                            show-word-limit
                            :rows="3"
                        ></el-input>
                    </el-form-item>

                    <el-form-item
                        prop="published"
                        label="状态"
                        :error="createError.published ? createError.published[0] : ''"
                    >
                        <el-switch
                            active-value="1"
                            inactive-value="0"
                            v-model="createNavigationForm.published"
                        >
                        </el-switch>
                    </el-form-item>
                </el-form>
                <span slot="footer" class="dialog-footer">
        <el-button @click="createNavigationVisible = false">取消</el-button>
        <el-button
            type="primary"
            :loading="createLoading"
            @click="createNavigation('createForm')"
        >保存</el-button
        >
      </span>
            </el-dialog>
            <!-- 修改导航 -->
            <el-dialog
                custom-class="dialog_tc"
                title="修改导航"
                :visible.sync="updateNavigationVisible"
                width="560px"
                :close-on-click-modal="false"
            >
                <el-form
                    ref="updateForm"
                    :model="updateNavigationForm"
                    label-width="80px"
                    size="medium"
                >

                    <el-form-item
                        label="所属分类"
                        prop="category_id"
                        :error="updateError.category_id ? updateError.category_id[0] : ''"
                    >
                        <el-cascader
                            v-model="updateNavigationForm.category_id"
                            :options="category_options"
                            clearable
                            filterable
                            :props="{
                              checkStrictly: true,
                              label: 'name',
                              value: 'id',
                              expandTrigger: 'click',
                            }"
                            placeholder="请选择所属分类"
                        >
                            <template slot-scope="{ node, data }">
                                <span>{{ data.name }}</span>
                                <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
                            </template>
                        </el-cascader>
                    </el-form-item>
                    <el-form-item
                        prop="name"
                        label="导航名称"
                        required
                        :error="updateError.name ? updateError.name[0] : ''"
                    >
                        <el-input
                            type="text"
                            placeholder="请输入导航名称"
                            v-model="updateNavigationForm.name"
                        ></el-input>
                    </el-form-item>

                    <el-form-item
                        prop="url"
                        label="导航地址"
                        :error="updateError.url ? updateError.url[0] : ''"
                    >
                        <el-input
                            type="text"
                            placeholder="请输入导航地址"
                            v-model="updateNavigationForm.url"
                        ></el-input>
                    </el-form-item>
                    <el-form-item
                        label="缩略图"
                        class="upload_thumb"
                        prop="image_path"
                        :error="updateError.file ? updateError.file[0] : ''"
                    >
                        <el-upload
                            class="uploadThumbImg"
                            :headers="headers"
                            :action="action"
                            :show-file-list="false"
                            :on-success="successUploadEdit"
                            :before-upload="beforeUploadEdit"
                            :on-error="errorUploadEdit"
                            :data="uploadData"
                        >
                            <img
                                v-if="updateNavigationForm.image_path"
                                :src="editImageUrlPreview"
                                class="thumb"
                            />
                            <i v-else class="el-icon-plus"></i>
                        </el-upload>
                        <div class="el-upload__tip">
                            支持JPG/PNG格式，建议尺寸800*450px或16:9
                            <br/>图片大小不超过1MB
                        </div>
                    </el-form-item>

                    <el-form-item
                        prop="description"
                        label="简介"
                        :error="updateError.description ? updateError.description[0] : ''"
                    >
                        <el-input
                            type="textarea"
                            v-model="updateNavigationForm.description"
                            placeholder="请输入简介"
                            maxlength="500"
                            show-word-limit
                            :rows="3"
                        ></el-input>
                    </el-form-item>
                    <el-form-item
                        prop="target"
                        label="打开方式"
                        :error="updateError.target ? updateError.target[0] : ''"
                    >
                        <el-radio v-model="updateNavigationForm.target" label="_self">当前窗口</el-radio>
                        <el-radio v-model="updateNavigationForm.target" label="_blank">新建窗口</el-radio>
                    </el-form-item>
                    <el-form-item
                        prop="published"
                        label="状态"
                        :error="updateError.published ? updateError.published[0] : ''"
                    >
                        <el-switch
                            :active-value="1"
                            :inactive-value="0"
                            v-model="updateNavigationForm.published"
                        >
                        </el-switch>
                    </el-form-item>
                </el-form>
                <span slot="footer" class="dialog-footer">
        <el-button @click="updateNavigationVisible = false">取消</el-button>
        <el-button
            type="primary"
            :loading="updateLoading"
            @click="updateNavigation('updateForm')"
        >保存</el-button
        >
      </span>
            </el-dialog>
        </div>
    </div>
</template>
<script>

import {index, store, show, update, destroy, updateSort} from "../../api/navigation";
import {getToken} from "@/utils/auth";
import {getBaseApi, getBaseHost} from "@/utils/index";
import {category} from "../../api/category";

var diguiList = [];
var i = 0;
export default {
    props: {
        category_id: {
            type: Number,
            default: '',
        },
    },
    data() {
        return {
            headers: {},
            action: "",
            uploadData: {},
            createNavigationVisible: false,
            updateNavigationVisible: false,
            navigation_options: [],
            loading: false,
            tableData: [],
            createLoading: false,
            updateLoading: false,
            createError: {},
            updateError: {},
            imageUrlPreview: "",
            editImageUrlPreview: "",
            category_options: [],
            createNavigationForm: {
                name: "",
                url: "",
                category_id: "",
                image_path: "",
                description: "",
                published: true,
                sort: 0,
                target: "_blank",
            },
            updateNavigationForm: {
                id: "",
                name: "",
                url: "",
                category_id: "",
                image_path: "",
                description: "",
                target: "_blank",
                published: "",
                sort: "",
            },
        }
    },
    watch: {
        category_id() {
            this.getNavigation()
        }
    },
    mounted() {
        this.setAction();
        this.setHeader()
        this.getCategory()
        this.getNavigation();
    },
    methods: {
        updateNavigation(formName) {
            this.updateError = {};
            this.updateLoading = true;
            const category_id = this.updateNavigationForm.category_id;
            if (category_id instanceof Array) {
                this.updateNavigationForm.category_id = category_id.slice(-1)[0];
            }
            update(this.updateNavigationForm.id, this.updateNavigationForm)
                .then((response) => {
                    this.$message({
                        message: response.message,
                        type: "success",
                    });
                    this.updateNavigationVisible = false;
                    this.getNavigation();
                    this.resetCreateForm(formName);
                })
                .catch((reason) => {
                    const {data} = reason;
                    if (reason.code === 422) {
                        this.updateError = data;
                    }
                })
                .finally(() => {
                    this.updateLoading = false;
                });
        },
        handleEdit(row) {
            this.updateError = {};
            show(row.id).then((response) => {
                const {data} = response;
                this.updateNavigationVisible = true;
                this.updateNavigationForm = data;
                let category_id = [];
                category_id = this.parentData(
                    [],
                    data.category_id,
                    this.category_options
                );
                this.updateNavigationForm.category_id =
                    category_id.length == 0 ? [0] : category_id;
                this.updateLoading = false;
                this.editImageUrlPreview =
                    getBaseHost() + data.image_path;

            });
        },
        handleRemove(data) {

            this.$confirm(
                '确定要删除么？',
                '提示',
                {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning",
                }
            )
                .then(() => {
                    destroy(data.id)
                        .then(() => {
                            this.$message({
                                type: "success",
                                message: "删除成功!",
                            });
                            this.getNavigation();
                        })
                        .catch((reason) => {
                            const {data} = reason.response;
                            if (data.code !== 200) {
                                this.$message({
                                    type: "info",
                                    message: data.message,
                                });
                            }
                        });
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: '取消删除',
                    });
                });

        },
        parentData(parent_id, cur, category_options) {
            category_options.forEach((element) => {
                if (cur == element.id) {
                    if (cur != 0) {
                        parent_id.unshift(element.id);
                        this.parentData(
                            parent_id,
                            element.parent_id,
                            this.category_options
                        );
                    }
                } else if (element.children instanceof Array) {
                    this.parentData(parent_id, cur, element.children);
                }
            });
            return parent_id;
        },
        setHeader() {
            this.headers = {
                Authorization: "Bearer " + getToken(),
            };
        },
        setAction() {
            this.action = getBaseApi() + "/WebNav/file/upload";
        },
        // 上传成功
        successUpload(response, file, fileList) {
            this.imageUrlPreview = getBaseHost() + response.data.path;
            this.createNavigationForm.image_path = response.data.path;
        },
        errorUpload(response, file, fileList){
            let myError=response.toString();
            myError=myError.replace("Error: ","")
            myError=JSON.parse(myError);
            this.createError = myError.data;
        },
        beforeUpload(file) {
            const directory = "/navigation";
            this.uploadData.directory = directory;
            this.uploadData.name = file.name;
        },

        // 上传成功
        successUploadEdit(response, file, fileList) {
            this.editImageUrlPreview = ''
            this.editImageUrlPreview = getBaseHost() + response.data.path;
            this.updateNavigationForm.image_path = response.data.path;
        },
        errorUploadEdit(response, file, fileList){
            let myError=response.toString();
            myError=myError.replace("Error: ","")
            myError=JSON.parse(myError);
            this.updateError = myError.data;
        },
        beforeUploadEdit(file) {
            let directory = "/navigation";
            this.uploadData.directory = directory;
            this.uploadData.name = file.name;
        },
        resetCreateForm(formName) {
            this.$refs[formName].resetFields();
        },
        createNavigation(formName) {
            this.createLoading = true;
            this.createError = {};
            const category_id = this.createNavigationForm.category_id;
            if (category_id instanceof Array) {
                this.createNavigationForm.category_id = category_id.slice(-1)[0];
            }
            store(this.createNavigationForm)
                .then((response) => {
                    this.$message({
                        message: response.message,
                        type: "success",
                    });
                    this.resetCreateForm(formName);
                    this.getNavigation();
                    this.createNavigationVisible = false;
                })
                .catch((reason) => {
                    const {data} = reason;
                    if (reason.code === 422) {
                        this.createError = data;
                    }
                })
                .finally(() => {
                    this.createLoading = false;
                });
        },
        getNavigation() {
            this.loading = true;
            this.createNavigationForm.category_id = this.category_id
            const requestData = {
                category_id: this.category_id
            };
            index(requestData)
                .then((response) => {
                    const {data} = response;
                    this.loading = false;
                    this.tableData = JSON.parse(JSON.stringify(data.navigation));
                    this.navigation_options = JSON.parse(JSON.stringify(data.navigation));
                    this.navigation_options.unshift({
                        id: 0,
                        name: "顶级导航",
                    });
                })
                .catch((reason) => {
                    this.loading = false;
                    this.tableData = [];
                    this.total = 0;
                });
        },
        getCategory() {
            this.loading = true;
            const requestData = {};
            category(requestData)
                .then((response) => {
                    const {data} = response;
                    this.loading = false;
                    this.category_options = data.category;
                })
                .catch((reason) => {
                    this.loading = false;
                    this.tableData = [];
                    this.total = 0;
                });
        },
    }
}
</script>
