<template>
  <a-layout class="content">
      <a-menu theme="light" v-model="current" mode="horizontal">
        <a-menu-item key="search">Marking</a-menu-item>
        <a-menu-item  key="exit" @click="exit">Exit</a-menu-item>
      </a-menu>

    <a-layout-content 
      <component v-bind:is="currentComponent"></component>
    </a-layout-content>
    <!-- <a-layout-footer></a-layout-footer> -->
  </a-layout>
</template>
<script>
import Search from "./Home/Search";
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
    Search
  },
  mounted() {
  },
  methods: {
        ...mapActions(["LogOut"]),
    exit() {
      this.LogOut().then(result => {
        if (result) {
          this.$router.push("/Login");
        }
      });
    }
  }
};
</script>

<style scoped>
content .content {
  background-color: #fff;
}
</style>