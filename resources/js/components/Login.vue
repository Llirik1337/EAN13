<template>
  <a-row class="main-block" justify="center" type="flex" align="middle">
    <a-col>
      <p class="form-title">Authorization</p>
      <a-form :form="form" class="login-form" @submit="handleSubmit">
        <a-form-item>
          <a-input
            v-decorator="[
          'name',
          { rules: [{ required: true, message: 'Please enter login!' }] },
        ]"
            placeholder="Login"
          >
            <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)" />
          </a-input>
        </a-form-item>
        <a-form-item>
          <a-input
            v-decorator="[
          'password',
          { rules: [{ required: true, message: 'Please enter password!' }] },
        ]"
            type="password"
            placeholder="Password"
          >
            <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
          </a-input>
        </a-form-item>
        <a-form-item>
          <a-button type="primary" html-type="submit" block>Enter</a-button>
        </a-form-item>
      </a-form>
    </a-col>
  </a-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "Login",
  data: function() {
    return {
      isLogin: false
    };
  },
  beforeCreate() {
    this.form = this.$form.createForm(this, { name: "normal_login" });
  },
  computed: {
    ...mapGetters(["getUser"])
  },
  beforeMount() {
    // this.Init().then(result => {
    //   // console.log("mounted");

    //   // console.log(this.getUser);
    //   if (this.getUser) {
    //     // console.log("go to home");
    //     this.$router.push("/Home");
    //   }
    // });
  },
  updated() {},

  methods: {
    ...mapActions(["LoginIn", "Init"]),
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          // console.log("Received values of form: ", values);
          this.LoginIn(values)
            .then(
              result => {
                // console.log(result);
                // console.log("Login in ");
                if (this.getUser) {
                  this.$router.push("/Home");
                }
              },
              result => {
                // // console.log(result);
              }
            )
            .catch(e => {
              // console.log(e);
            });
        }
      });
    }
  }
};
</script>
<style>
.main-block {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.form-title {
  font-size: 32pt;
  width: 100%;
  text-align: center;
  margin: 0px;
}
.login-form {
  width: 500px;
}
</style>