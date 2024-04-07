<template>
  <div class="marketing_content">

    <div class="marketing_main">
      <el-divider content-position="left">个人信息 ---- 修改密码</el-divider>
      <div style="margin-top: 50px">
        <el-form ref="updateForm" :model="updateForm" label-width="90px" size="medium">
          <el-form-item
            label="密码"
            prop="title"
            :error="updateError.password ? updateError.password[0] : ''"
          >
            <el-input v-model="updateForm.password" placeholder="请输入密码" clearable/>
          </el-form-item>
        </el-form>
      </div>
      <span style="margin-left: 90px;">
        <el-button
          type="primary"
          :loading="updateLoading"
          @click="onUpdate('updateForm')"
          style="margin-top: 20px"
        >{{ updateLoading ? '提交中 ...' : '提 交' }}</el-button>
      </span>
    </div>
  </div>
</template>
<script>
import {updatePassword} from '~/api/user'

export default {
  data() {
    return {
      updateError:{},
      updateLoading:false,
      updateForm:{
        password:''
      }
    }
  },
  mounted() {

  },
  methods: {
    onUpdate(){
      this.updateLoading=true
      updatePassword(this.updateForm).then(res=>{
        this.$message({
          message: res.message,
          type: 'success'
        });
        this.updateLoading=false
      }).catch(err=>{
        this.updateError = err.data
        this.updateLoading=false
      })
    }
  }
}
</script>
