<template>
  <a-row type="flex" justify="center" class="createUser">
    <a-col :span="12">
      <a-form :form="form" layout="vertical" @submit="create">
        <a-form-item label="Login" :label-col="{ span: 4 }" :wrapper-col="{ span: 16 }">
          <a-input
            v-decorator="['login', { rules: [{ required: true, message: 'Please input login!' }] }]"
          />
        </a-form-item>
        <a-form-item label="Password" :label-col="{ span: 4 }" :wrapper-col="{ span: 16 }">
          <a-input
            v-decorator="['password', { rules: [{ required: true, message: 'Please input password!' }] }]"
          />
        </a-form-item>
        <a-form-item label="Company" :label-col="{ span: 4 }" :wrapper-col="{ span: 16 }">
          <a-input
            v-decorator="['company', { rules: [{ required: true, message: 'Please input company!' }] }]"
          />
        </a-form-item>
        <!-- <a-form-item label="Password" :label-col="{ span: 3 }" :wrapper-col="{ span: 21 }"></a-form-item> -->
        <a-form-item :wrapper-col="{ offset:4 }">
          <a-button type="primary" html-type="submit">Create</a-button>
        </a-form-item>
      </a-form>
      <a-alert v-if="msg!==null" :message="msg" banner></a-alert>
    </a-col>
  </a-row>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "AdminPanel",
  data: function() {
    return {
      form: this.$form.createForm(this, { name: "createUser" }),
      msg: null
    };
  },

  mounted() {},
  methods: {
    ...mapActions(["createUser"]),
    create(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          this.createUser(values).then(res => {
              console.log(res);
              this.msg = res.msg;
          });
        }
      });
    }
  }
};
</script>

<style>
.createUser {
  padding: 20px;
  background-color: #fff;
}
</style>
