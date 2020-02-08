<template>
  <a-layout class="content">
    <a-menu theme="light" v-model="current" mode="horizontal">
      <a-menu-item key="search">Marking</a-menu-item>
      <a-menu-item key="statistics">Statistics</a-menu-item>
      <a-menu-item key="adminPanel">Admin Panel</a-menu-item>
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
      current: ["search"]
    };
  },
  components: {
    Search,
    AdminPanel,
    Statistics
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
  mounted() {},
  methods: {
    ...mapActions(["LogOut"]),
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
