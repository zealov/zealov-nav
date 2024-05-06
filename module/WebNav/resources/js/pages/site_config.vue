<template>
    <div class="content_container">
        <div class="container material-box" style="padding-top: 0; padding-bottom: 0">
            <div class="header_container is-sticky-top">
                <div class="left">
                    <el-button
                        size="small"
                        type="primary"
                        @click="createSiteConfigVisible = true"
                    ><i class="el-icon-plus"></i> 添加
                    </el-button
                    >
                </div>
                <!-- 筛选区 -->
                <div class="right">
                    <div class="filter">
                        <el-form :inline="true" size="small">
                            <el-form-item>
                                <el-input placeholder="请输入关键字" v-model="filter.keywords">
                                </el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button size="small"
                                ><i class="el-icon-search"></i
                                ></el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </div>
            <div class="material-content">
                <div class="material-left">
                    <div class="material-group">
                        <div class="top">
                            <div class="title">分组</div>
                            <el-button
                                type="text"
                            >
                            </el-button>
                        </div>
                        <div class="group-tree">
                            <el-scrollbar>
                                <el-tree
                                    :data="groupTreeData"
                                    node-key="id"
                                    default-expand-all
                                    :expand-on-click-node="false"
                                    :highlight-current="true"
                                >
                                      <span
                                          class="custom-tree-node"
                                          slot-scope="{ node, data }"
                                          @click="selectGroup(data)"
                                      >
                                    <i class="el-icon-folder"></i>
                                    <span class="node-name">{{ data.group }}</span>
                                </span>
                                </el-tree>
                            </el-scrollbar>
                        </div>
                    </div>
                </div>
                <div
                    class="material-right"
                >
                    <div class="material_list">

                        <el-scrollbar>
                            <div class="scrollbar-table">
                                <el-table :data="tableData" v-loading="loading" tooltip-effect="dark">
                                    <el-table-column
                                        prop="name"
                                        :show-overflow-tooltip="true"
                                        min-width="15%"
                                        label="配置名称"
                                        align="left"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        prop="key"
                                        :show-overflow-tooltip="true"
                                        min-width="15%"
                                        label="键"
                                        align="left"
                                    >
                                    </el-table-column>

                                    <el-table-column
                                        prop="value"
                                        :show-overflow-tooltip="true"
                                        min-width="15%"
                                        label="值"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        prop="type"
                                        :show-overflow-tooltip="true"
                                        min-width="15%"
                                        label="类型"
                                    >
                                    </el-table-column>
                                    <el-table-column align="center" label="操作" width="80">
                                        <template slot-scope="scope">
                                            <el-button
                                                type="text"
                                                title="编辑"
                                                @click="handleEdit(scope.row)"
                                            ><i class="el-icon-edit"></i
                                            ></el-button>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </div>
                        </el-scrollbar>
                    </div>
                </div>
            </div>
        </div>
        <!-- 添加 -->
        <el-dialog
            custom-class="dialog_tc"
            title="创建"
            :visible.sync="createSiteConfigVisible"
            width="560px"
            :close-on-click-modal="false"
        >
            <el-form
                ref="createForm"
                :model="createSiteConfigForm"
                label-width="80px"
                size="medium"
            >
                <el-form-item
                    prop="group"
                    label="名称"
                    required
                    :error="createError.group ? createError.group[0] : ''"
                >
                    <el-select v-model="createSiteConfigForm.group" placeholder="请选择分组">
                        <el-option
                            v-for="item in group_options"
                            :key="item.group"
                            :label="item.group"
                            :value="item.group">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item
                    prop="name"
                    label="名称"
                    required
                    :error="createError.name ? createError.name[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="请输入名称"
                        v-model="createSiteConfigForm.name"
                    ></el-input>
                </el-form-item>
                <el-form-item
                    prop="key"
                    label="键名"
                    required
                    :error="createError.key ? createError.key[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="请输入键名，添加之后不可修改"
                        v-model="createSiteConfigForm.key"
                    ></el-input>
                </el-form-item>
                <el-form-item label="类型" required>
                    <el-select
                        v-model="createSiteConfigForm.type"
                        placeholder="请选择类型"
                        @change="setChanceData(createSiteConfigForm.type)"
                    >
                        <el-option
                            v-for="item in typeArr"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item
                    label="文件"
                    class="upload_thumb"
                    prop="value"
                    v-if="createSiteConfigForm.type=='file'"
                >
                    <el-upload
                        class="uploadThumbImg"
                        :headers="headers"
                        :action="action"
                        :show-file-list="false"
                        :on-success="successUpload"
                        :before-upload="beforeUpload"
                        :data="uploadData"
                    >
                        <img
                            v-if="createSiteConfigForm.value"
                            :src="imageUrlPreview"
                            class="thumb"
                        />
                        <i v-else class="el-icon-plus"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item
                    prop="value"
                    label="值"
                    :error="createError.value ? createError.value[0] : ''"
                >
                    <el-input
                        type="textarea"
                        placeholder="请输入值"
                        v-model="createSiteConfigForm.value"
                    ></el-input>
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
        <el-button @click="createSiteConfigVisible = false">取消</el-button>
        <el-button
            type="primary"
            :loading="createLoading"
            @click="createSiteConfig('createForm')"
        >保存</el-button
        >
      </span>
        </el-dialog>
        <!-- 编辑 -->
        <el-dialog
            custom-class="dialog_tc"
            title="编辑"
            :visible.sync="updateSiteConfigVisible"
            width="560px"
            :close-on-click-modal="false"
        >
            <el-form
                ref="updateForm"
                :model="updateSiteConfigForm"
                label-width="80px"
                size="medium"
            >
                <el-form-item
                    prop="group"
                    label="分组"
                    required
                    :error="updateError.group ? updateError.group[0] : ''"
                >
                    <el-select v-model="updateSiteConfigForm.group" placeholder="请选择分组">
                        <el-option
                            v-for="item in group_options"
                            :key="item.group"
                            :label="item.group"
                            :value="item.group">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item
                    prop="name"
                    label="名称"
                    required
                    :error="updateError.name ? updateError.name[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="请输入名称"
                        v-model="updateSiteConfigForm.name"
                    ></el-input>
                </el-form-item>
                <el-form-item
                    prop="key"
                    label="键名"
                    required
                    :error="updateError.key ? updateError.key[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="请输入键名，添加之后不可修改"
                        v-model="updateSiteConfigForm.key"
                    ></el-input>
                </el-form-item>
                <el-form-item label="类型" required>
                    <el-select
                        v-model="updateSiteConfigForm.type"
                        placeholder="请选择类型"
                        @change="setChanceData(updateSiteConfigForm.type)"
                    >
                        <el-option
                            v-for="item in typeArr"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item
                    label="文件"
                    class="upload_thumb"
                    prop="value"
                    v-if="updateSiteConfigForm.type=='file'"
                >
                    <el-upload
                        class="uploadThumbImg"
                        :headers="headers"
                        :action="action"
                        :show-file-list="false"
                        :on-success="successUploadEdit"
                        :before-upload="beforeUploadEdit"
                        :data="uploadData"
                    >
                        <img
                            v-if="editImageUrlPreview"
                            :src="editImageUrlPreview"
                            class="thumb"
                        />
                        <i v-else class="el-icon-plus"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="值" required v-if="updateSiteConfigForm.type=='select'">
                    <el-select
                        v-model="updateSiteConfigForm.value"
                        placeholder="请选择"
                    >
                        <el-option
                            v-for="item in siteTemplateData"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item
                    v-else
                    prop="value"
                    label="值"
                    :error="updateError.value ? updateError.value[0] : ''"
                >
                    <el-input
                        type="textarea"
                        placeholder="请输入值"
                        v-model="updateSiteConfigForm.value"
                    ></el-input>
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
        <el-button @click="updateSiteConfigVisible = false">取消</el-button>
        <el-button
            type="primary"
            :loading="updateLoading"
            @click="updateSiteConfig('updateForm')"
        >保存</el-button
        >
      </span>
        </el-dialog>
    </div>
</template>

<script>
import {store, index, show, update, group,siteTemplate} from '../api/config'
import {getBaseApi, getBaseHost} from "@/utils/index";
import { getToken } from "@/utils/auth";
export default {
    data() {
        return {
            group: '',
            updateError: {},
            updateLoading: false,
            updateSiteConfigVisible: false,
            groupTreeData: [],
            loading: false,
            createLoading: false,
            createError: {},
            createSiteConfigVisible: false,
            group_options: [],
            siteTemplateData:[],
            filter: {
                keywords: "",
            },
            uploadData: {},
            headers: {},
            imageUrlPreview: "",
            editImageUrlPreview:"",
            action: "",
            typeArr: [
                {
                    value: "string",
                    label: "字符串",
                },
                {
                    value: "file",
                    label: "文件",
                },
                {
                    value: "select",
                    label: "模板选择",
                }
            ],
            createSiteConfigForm: {
                name: '',
                key: '',
                value: '',
                group: '',
                type: 'string',
            },
            updateSiteConfigForm: {
                id: '',
                name: '',
                key: '',
                value: '',
                group: '',
                type: '',
            },
            tableData: [],
        }
    },
    created() {
        this.getSiteTemplate()
        this.getSiteConfig()
        this.getSiteConfigGroup()
        this.setAction();
        this.setHeader()
    },
    methods: {
        getSiteTemplate(){
            siteTemplate().then((response) => {
                this.siteTemplateData = response.data.data
                console.log(response)
            })
        },
        setAction() {
            this.action = getBaseApi() + "/WebNav/file/upload";
        },
        setHeader() {
            this.headers = {
                Authorization: "Bearer " + getToken(),
            };
        },
        // 上传成功
        successUpload(response, file, fileList) {
            this.imageUrlPreview = getBaseHost() + response.data.path;
            this.createSiteConfigForm.value = response.data.path;
        },
        beforeUpload(file) {
            const directory = "/system_file";
            this.uploadData.directory = directory;
            this.uploadData.name = file.name;
        },
        // 上传成功
        successUploadEdit(response, file, fileList) {
            this.editImageUrlPreview = getBaseHost() + response.data.path;
            this.updateSiteConfigForm.value = response.data.path;
        },
        beforeUploadEdit(file) {
            const directory = "/system_file";
            this.uploadData.directory = directory;
            this.uploadData.name = file.name;
        },
        handleEdit(item) {
            show(item.id).then((response) => {
                this.updateSiteConfigForm.id = response.data.id
                this.updateSiteConfigForm.name = response.data.name
                this.updateSiteConfigForm.key = response.data.key
                this.updateSiteConfigForm.value = response.data.value
                this.updateSiteConfigForm.type = response.data.type
                this.updateSiteConfigForm.group = response.data.group
                this.updateSiteConfigVisible = true;
                if(response.data.type=='file'){
                    this.editImageUrlPreview = getBaseHost() + response.data.value;
                }
            })
        },
        selectGroup(item) {
            if (item.group == '全部') {
                this.group = ''
            } else {
                this.group = item.group
            }
            this.getSiteConfig()
        },
        updateSiteConfig() {
            this.updateError = {};
            this.updateLoading = true;
            update(this.updateSiteConfigForm.id, this.updateSiteConfigForm)
                .then((response) => {
                    this.$message({
                        message: response.message,
                        type: "success",
                    });
                    this.updateSiteConfigVisible = false;
                    this.getSiteConfig();
                })
                .catch((reason) => {
                    const { data } = reason;
                    if (reason.code === 422) {
                        this.updateError = data;
                    }
                })
                .finally(() => {
                    this.updateLoading = false;
                });
        },
        getSiteConfigGroup() {
            group().then((response) => {
                const {data} = response;
                this.groupTreeData = JSON.parse(JSON.stringify(data.group));
                this.group_options = JSON.parse(JSON.stringify(data.group));
                this.groupTreeData.unshift({
                    group: "全部",
                });
            })
        },
        //获取选项渲染
        setChanceData(e) {

        },
        getSiteConfig() {
            this.loading = true;
            const requestData = {
                group: this.group
            };
            index(requestData)
                .then((response) => {
                    const {data} = response;
                    this.loading = false;
                    this.tableData = JSON.parse(JSON.stringify(data.config));
                })
                .catch((reason) => {
                    this.loading = false;
                    this.tableData = [];
                    this.total = 0;
                });
        },
        resetCreateForm(formName) {
            this.$refs[formName].resetFields();
        },
        createSiteConfig(formName) {
            this.createLoading = true;
            this.createError = {};
            store(this.createSiteConfigForm)
                .then((response) => {
                    this.$message({
                        message: response.message,
                        type: "success",
                    });
                    this.resetCreateForm(formName);
                    this.getSiteConfig()
                    this.createSiteConfigVisible = false;
                })
                .catch((reason) => {
                    if (reason.code === 422) {
                        this.createError = reason.data;
                    }
                })
                .finally(() => {
                    this.createLoading = false;
                });
        }
    }
}
</script>
