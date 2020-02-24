<template>
  <a-table
    :dataSource="tableData"
    :rowKey="record => record.code"
    :columns="columns"
    :loading="loadingData"
  ></a-table>
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
    title: "DM free",
    dataIndex: "free"
  },
  {
    title: "DM  print",
    dataIndex: "printed"
  },
  {
    title: "DM Inflicted",
    dataIndex: "inflicted"
  },
  {
    title: "DM Package",
    dataIndex: "package"
  },
  {
    title: "DM Shipped",
    dataIndex: "invoice"
  }
];

export default {
  name: "Statistics",
  data: function() {
    return {
      tableData: [],
      columns,
      loadingData: true
    };
  },

  mounted() {
    this.updateStatistics().then(res => {
      this.tableData = this.getStatistics;
      this.loadingData = false;
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
