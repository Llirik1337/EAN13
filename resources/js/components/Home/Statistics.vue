<template>
  <a-table :dataSource="tableData" :columns="columns" ></a-table>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

const columns = [
  {
    title: "EAN-13",
    dataIndex: "code"
  },
  {
    title: "Tovar name",
    dataIndex: "tovarname"
  },
  {
      title: 'DM free',
      dataIndex: 'free'
  },
  {
      title: 'DM  print',
      dataIndex: 'printed'
  },
  {
      title: 'DM Inflicted',
      dataIndex: 'inflicted'
  }
];

export default {
  name: "Statistics",
  data: function() {
    return {
      tableData: [],
      columns
    };
  },

  mounted() {
    this.updateStatistics().then(res => {
      this.tableData = this.getStatistics;
      console.log(this.tableData);
    });
  },
  computed: {
    ...mapGetters(["getStatistics"])
  },
  methods: {
    ...mapActions(["updateStatistics"])
  }
};
</script>

<style>
</style>
