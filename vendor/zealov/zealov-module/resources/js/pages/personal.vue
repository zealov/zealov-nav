<template>
  <div class="content_container">
    <div style="height: 100%">
      <el-tabs :tab-position="tabPosition" class="myTab">
        <el-tab-pane label="个人信息">
          <personal-base />
        </el-tab-pane>
        <el-tab-pane label="修改密码">
          <personal-password />
        </el-tab-pane>
      </el-tabs>
    </div>


  </div>
</template>
<script>
import personalBase from '~/components/personal/personal-base.vue'
import personalPassword from '~/components/personal/personal-password.vue'

export default {
  layout: 'basic',
  middleware: 'auth',
  components:{
    personalBase,
    personalPassword
  },
  data() {
    return {
      tabPosition: 'left',
    }
  },
  mounted() {

  },
  methods: {


  }
}
</script>


