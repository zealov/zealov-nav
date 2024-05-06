<template>
    <div class="content_container">
        <div class="container material-box" style="padding-top: 0; padding-bottom: 0">
            <div class="material-content" style="top:20px">
                <div class="material-left">
                    <div class="material-group">
                        <div class="top" style="background-color: #f0f0f0;padding-bottom: 15px">
                            <div class="title" @click="category_id=''">分类</div>
                            <el-button
                                type="text"
                                @click="createCategoryVisible = true"
                            ><i class="el-icon-circle-plus-outline"></i>
                            </el-button>
                        </div>
                        <div class="group-tree">
                            <el-scrollbar>
                                <el-tree
                                    :data="tableData"
                                    node-key="id"
                                    default-expand-all
                                    :expand-on-click-node="false"
                                    :highlight-current="true"

                                >
                                      <span
                                          @click="setCategory(data)"
                                          class="custom-tree-node"
                                          slot-scope="{ node, data }"
                                      >
                                          <el-tooltip
                                              class="item"
                                              effect="light"
                                              placement="top-start"
                                              :disabled="true"
                                          >
                                          <span class="node-name"  >{{ data.name }}</span>
                                        </el-tooltip>
                                          <span class="button" v-if="data.name!='全部分类'">
                                      <el-button
                                          type="text"
                                          size="mini"
                                          @click="handleEdit(data)"
                                      >
                                        <i class="el-icon-edit"></i>
                                      </el-button>
                                      <el-button
                                          type="text"
                                          size="mini"
                                          @click="createChildren(data)"
                                      >
                                        <i class="el-icon-circle-plus-outline"></i>
                                      </el-button>
                                    </span>
                                    </span>

                                </el-tree>
                            </el-scrollbar>
                        </div>
                    </div>
                </div>
                <div
                    class="material-right"
                >
                    <NavigationTable :category_id="category_id" ref="child"></NavigationTable>
                </div>
            </div>
        </div>
        <!-- 添加分类 -->
        <el-dialog
            custom-class="dialog_tc"
            title="添加分类"
            :visible.sync="createCategoryVisible"
            width="560px"
            :close-on-click-modal="false"
        >
            <el-form
                ref="createForm"
                :model="createCategoryForm"
                label-width="80px"
                size="medium"
            >
                <el-form-item
                    label="上级分类"
                    prop="parent_id"
                    :error="createError.parent_id ? createError.parent_id[0] : ''"
                >
                    <el-cascader
                        v-model="createCategoryForm.parent_id"
                        :options="category_options"
                        clearable
                        filterable
                        :props="{
                          checkStrictly: true,
                          label: 'name',
                          value: 'id',
                          expandTrigger: 'click',
                        }"
                        placeholder="请选择上级分类"
                    >
                        <template slot-scope="{ node, data }">
                            <span>{{ data.name }}</span>
                            <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
                        </template>
                    </el-cascader>
                </el-form-item>
                <el-form-item
                    prop="name"
                    label="分类名称"
                    required
                    :error="createError.name ? createError.name[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="请输入分类名称"
                        v-model="createCategoryForm.name"
                    ></el-input>
                </el-form-item>

                <el-form-item
                    prop="label"
                    label="分类标识"
                    required
                    :error="createError.label ? createError.label[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="限英文字母,设定后不可修改"
                        v-model="createCategoryForm.label"
                    ></el-input>
                </el-form-item>
                <el-form-item
                    label="缩略图"
                    class="upload_thumb"
                    prop="thumbnail"
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
                            v-if="createCategoryForm.image_path"
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
                        v-model="createCategoryForm.description"
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
                        v-model="createCategoryForm.published"
                    >
                    </el-switch>
                </el-form-item>
                <el-form-item
                    prop="published"
                    label="导航位置"
                    :error="updateError.plice ? updateError.plice[0] : ''"
                >
                    <el-radio v-model="createCategoryForm.place" label="sidebar">侧栏</el-radio>
                    <el-radio v-model="createCategoryForm.place" label="main">主导航</el-radio>

                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
        <el-button @click="createCategoryVisible = false">取消</el-button>
        <el-button
            type="primary"
            :loading="createLoading"
            @click="createCategory('createForm')"
        >确定</el-button
        >
      </span>
        </el-dialog>
        <!-- 修改分类 -->
        <el-dialog
            custom-class="dialog_tc"
            title="修改分类"
            :visible.sync="updateCategoryVisible"
            width="560px"
            :close-on-click-modal="false"
        >
            <el-form
                ref="updateForm"
                :model="updateCategoryForm"
                label-width="80px"
                size="medium"
            >
                <el-form-item
                    label="上级分类"
                    prop="parent_id"
                    :error="updateError.parent_id ? updateError.parent_id[0] : ''"
                >
                    <el-cascader
                        v-model="updateCategoryForm.parent_id"
                        :options="category_options"
                        clearable
                        filterable
                        :props="{
              checkStrictly: true,
              label: 'name',
              value: 'id',
              expandTrigger: 'click',
            }"
                        placeholder="请选择上级分类"
                    >
                        <template slot-scope="{ node, data }">
                            <span>{{ data.name }}</span>
                            <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
                        </template>
                    </el-cascader>
                </el-form-item>
                <el-form-item
                    prop="name"
                    label="分类名称"
                    required
                    :error="updateError.name ? updateError.name[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="请输入分类名称"
                        v-model="updateCategoryForm.name"
                    ></el-input>
                </el-form-item>

                <el-form-item
                    prop="label"
                    label="分类标识"
                    required
                    :error="updateError.label ? updateError.label[0] : ''"
                >
                    <el-input
                        type="text"
                        placeholder="限英文字母,设定后不可修改"
                        v-model="updateCategoryForm.label"
                    ></el-input>
                </el-form-item>
                <el-form-item
                    label="缩略图"
                    class="upload_thumb"
                    prop="thumbnail"
                    :error="updateError.file ? updateError.file[0] : ''"
                >
                    <el-upload
                        class="uploadThumbImg"
                        :headers="headers"
                        :action="action"
                        :show-file-list="false"
                        :on-success="successUploadEdit"
                        :before-upload="beforeUploadEdit"
                        :data="uploadData"
                        :on-error="errorUploadEdit"
                    >
                        <img
                            v-if="updateCategoryForm.image_path"
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
                        v-model="updateCategoryForm.description"
                        placeholder="请输入简介"
                        maxlength="500"
                        show-word-limit
                        :rows="3"
                    ></el-input>
                </el-form-item>

                <el-form-item
                    prop="published"
                    label="状态"
                    :error="updateError.published ? updateError.published[0] : ''"
                >
                    <el-switch
                        :active-value="1"
                        :inactive-value="0"
                        v-model="updateCategoryForm.published"
                    >
                    </el-switch>
                </el-form-item>
                <el-form-item
                    prop="published"
                    label="导航位置"
                    :error="updateError.plice ? updateError.plice[0] : ''"
                >
                    <el-radio v-model="updateCategoryForm.place" label="sidebar">侧栏</el-radio>
                    <el-radio v-model="updateCategoryForm.place" label="main">主导航</el-radio>

                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
        <el-button @click="updateCategoryVisible = false">取消</el-button>
        <el-button
            type="primary"
            :loading="updateLoading"
            @click="updateCategory('updateForm')"
        >修改</el-button
        >
      </span>
        </el-dialog>
    </div>
</template>

<script>
import NavigationTable from '../components/navigation_table'
import {category, create, show, update, destroy, updateSort} from "../../api/category";
import {getBaseApi, getBaseHost} from "@/utils/index";
import {getToken} from "@/utils/auth";

export default {
    data() {
        return {
            updateCategoryVisible: false,
            createCategoryVisible: false,
            updateError: {},
            updateLoading: false,
            loading: false,
            createLoading: false,
            createError: {},
            uploadData: {},
            headers: {},
            imageUrlPreview: "",
            editImageUrlPreview: "",
            action: "",
            tableData: [],
            category_options: [],
            category_id: '',
            createCategoryForm: {
                name: "",
                label: "",
                parent_id: [0],
                image_path: "",
                description: "",
                published: '1',
                sort: 0,
                place:"sidebar",
            },
            updateCategoryForm: {
                id: "",
                name: "",
                label: "",
                parent_id: "",
                image_path: "",
                description: "",
                published: "",
                sort: "",
                place:""
            },
        }
    },
    components: {
        NavigationTable
    },
    created() {
        this.setAction()
        this.setHeader()
        this.getCategory();
    },
    methods: {
        setCategory(data) {
            this.category_id = data.id
        },
        createChildren(data) {
            this.createCategoryVisible = true;
            let parent_id = [];
            parent_id = this.parentData([], data.id, this.category_options);
            this.createCategoryForm.parent_id = parent_id.length == 0 ? [0] : parent_id;
        },
        updateCategory() {
            this.updateError = {};
            this.updateLoading = true;
            const parent_id = this.updateCategoryForm.parent_id;
            if (parent_id instanceof Array) {
                this.updateCategoryForm.parent_id = parent_id.slice(-1)[0];
            }
            update(this.updateCategoryForm.id, this.updateCategoryForm)
                .then((response) => {
                    this.$message({
                        message: response.message,
                        type: "success",
                    });
                    this.updateCategoryVisible = false;
                    this.getCategory();
                    this.$refs.child.getCategory()
                })
                .catch((reason) => {
                    const {data} = reason;
                    this.updateError = data;
                })
                .finally(() => {
                    this.updateLoading = false;
                });

        },
        handleEdit(row) {
            this.updateError = {};
            show(row.id).then((response) => {
                const {data} = response;
                this.updateCategoryVisible = true;
                this.updateCategoryForm = data;
                let parent_id = [];
                parent_id = this.parentData([], data.parent_id, this.category_options);
                this.updateCategoryForm.parent_id = parent_id.length == 0 ? [0] : parent_id;
                this.updateLoading = false;
                this.editImageUrlPreview =
                    getBaseHost() + data.image_path;
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
        createCategory(formName) {
            this.createLoading = true;
            this.createError = {};
            const parent_id = this.createCategoryForm.parent_id;
            if (parent_id instanceof Array) {
                this.createCategoryForm.parent_id = parent_id.slice(-1)[0];
            }
            create(this.createCategoryForm)
                .then((response) => {
                    this.$message({
                        message: response.message,
                        type: "success",
                    });
                    this.resetCreateForm(formName);
                    this.getCategory();
                    this.createCategoryVisible = false;
                    this.$refs.child.getCategory()
                })
                .catch((reason) => {
                    const {data} = reason;
                    this.createError = data;
                })
                .finally(() => {
                    this.createLoading = false;
                });
        },
        getCategory() {
            this.loading = true;
            const requestData = {};
            category(requestData)
                .then((response) => {
                    const {data} = response;
                    this.loading = false;
                    this.tableData = JSON.parse(JSON.stringify(data.category));
                    this.category_options = JSON.parse(JSON.stringify(data.category));
                    this.category_options.unshift({
                        id: 0,
                        name: "顶级分类",
                    });
                    this.tableData.unshift({
                        name: "全部分类",
                    });
                })
                .catch((reason) => {
                    this.loading = false;
                    this.tableData = [];
                    this.total = 0;
                });
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
            this.createCategoryForm.image_path = response.data.path;
        },
        errorUpload(response, file, fileList){
            let myError=response.toString();
            myError=myError.replace("Error: ","")
            myError=JSON.parse(myError);
            this.createError = myError.data;
        },
        beforeUpload(file) {
            const directory = "/system_file";
            this.uploadData.directory = directory;
            this.uploadData.name = file.name;
        },
        // 上传成功
        successUploadEdit(response, file, fileList) {
            this.editImageUrlPreview = getBaseHost() + response.data.path;
            console.log(this.editImageUrlPreview)
            this.updateCategoryForm.image_path = response.data.path;
            console.log(this.updateCategoryForm)
        },
        errorUploadEdit(response, file, fileList){
            let myError=response.toString();
            myError=myError.replace("Error: ","")
            myError=JSON.parse(myError);
            this.updateError = myError.data;
        },
        beforeUploadEdit(file) {
            const directory = "/system_file";
            this.uploadData.directory = directory;
            this.uploadData.name = file.name;
        },


        resetCreateForm(formName) {
            this.$refs[formName].resetFields();
        },

    }
}
</script>
