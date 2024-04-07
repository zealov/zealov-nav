<template>
  <div class="marketing_content">

    <div class="marketing_main">
      <el-divider content-position="left">个人信息 ---- 基本信息</el-divider>
      <div style="margin-top: 50px">
        <el-form  label-width="90px" size="medium">
          <el-form-item
            label="账户："
            prop="title"
          >
            <div>{{ userInfo.name }}</div>
          </el-form-item>
          <el-form-item
            label="邮箱："
            prop="title"
          >
            <div>{{ userInfo.email }}</div>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>
<script>
import {getInfo} from '~/api/user'

export default {
  data() {
    return {
      userInfo:{
      }
    }
  },
  mounted() {
      getInfo().then(res=>{
      this.userInfo = res.data
    })
  },
  methods: {


  }
}
</script>
<style>
