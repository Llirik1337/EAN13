<template>
  <div>
    <a-row type="flex" justify="center">
      <a-col class="package">
        <a-row>
          <a-col>
            <a-input placeholder="Enter invoice number" v-model="invoice" @pressEnter="search" />
          </a-col>
          <a-col>
            <a-table
              :dataSource="shipments"
              :rowKey="record => record.code"
              :columns="columns"
              :loading="loadingData"
            >

            <span slot="code" slot-scope="text">
                {{text.slice(0,30)}}
            </span>

            </a-table>
          </a-col>
        </a-row>
      </a-col>
    </a-row>
  </div>
</template>

<script>
const columns = [
  {
    title: "DM",
    dataIndex: "code",
    scopedSlots: { customRender: 'code' },
  }
];

import { mapActions, mapGetters } from "vuex";
export default {
  name: "Shipment",
  data: function() {
    return {
      //   data: [],
      invoice: "",
      shipments: [],
      loadingData: false,
      columns: columns
    };
  },
  computed: {
    ...mapGetters(["getShipments"])
  },
  mounted() {},
  methods: {
    ...mapActions(["updateShipment"]),

    getLodaginData() {
      return this.loadingData;
    },

    setLoadingData(val) {
      this.loadingData = val;
    },

    setShipments(val) {
      this.shipments = val;
    },

    search() {
      this.setLoadingData(true);
      this.updateShipment(this.invoice).then(
        res => {
          this.setShipments(this.getShipments);

          this.setLoadingData(false);
        },
        res => {
            console.log(res);

          this.setLoadingData(false);
        }
      );
    }
  }
};
</script>

<style>
.package {
  width: 700px;
  padding: 20px;
}
.barcode {
  margin-top: 15px;
}
</style>
