<template>
  <a-layout class="content">
    <a-menu theme="light" v-model="current" mode="horizontal">
      <a-menu-item key="search">Marking</a-menu-item>
      <a-menu-item key="statistics">Statistics</a-menu-item>
      <a-menu-item v-show="isAdmin" key="adminPanel">Create user</a-menu-item>
      <a-menu-item key="exit" @click="exit">Exit</a-menu-item>
    </a-menu>

    <a-layout-content>
      <component v-bind:is="currentComponent"></component>
    </a-layout-content>
    <!-- <a-layout-footer></a-layout-footer> -->
  </a-layout>
</template>
<script>
import Search from "./Home/Search";
import AdminPanel from "./Home/AdminPanel";
import Statistics from "./Home/Statistics";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "Home",
  data: function() {
    return {
      currentComponent: Search,
      current: ["search"],
      isAdmin: false
    };
  },
  components: {
    Search,
    AdminPanel,
    Statistics
  },
  computed: {
    ...mapGetters(["getUser"])
  },
  watch: {
    current: function(new_val, old_val) {
      console.log(old_val);
      console.log(new_val);
      switch (new_val[0]) {
        case "search":
          this.currentComponent = Search;
          break;
        case "statistics":
          this.currentComponent = Statistics;
          break;
        case "adminPanel":
          this.currentComponent = AdminPanel;
          break;
      }
    }
  },
  beforeMount() {
    this.Init().then(res => {
      let user = this.getUser;
      console.log(user);

      if (user.user_types.name === "admin") {
        this.isAdmin = true;
      }
    });
  },
  mounted() {},
  methods: {
    ...mapActions(["LogOut", "Init"]),
    exit() {
      this.LogOut().then(result => {
        if (result) {
          this.$router.push("/Login");
        }
      });
    },
    getCurrentComponent() {
      return this.currentComponent;
    }
  }
};
</script>

<style scoped>
content .content {
  background-color: #fff;
}
</style>
