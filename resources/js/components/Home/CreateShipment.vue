<template>
  <div>
    <a-row type="flex" justify="center">
      <a-col class="package">
        <a-row>
          <a-col class="invoice">
            <a-input placeholder="Enter invoice number" v-model="invoice" />
          </a-col>
          <a-col>
            <a-input
              ref="addEAN"
              placeholder="Input EAN code package or box"
              v-model="code"
              @pressEnter="endInputCode"
            />
          </a-col>
          <a-col>
            <div class="demo-infinite-container" :infinite-scroll-distance="10">
              <a-list itemLayout="horizontal" :dataSource="data">
                <a-list-item slot="renderItem" slot-scope="item, index">
                  <!-- <a href="#" slot="actions" @click="deleteItem(index)">Delete</a> -->
                  <a-popconfirm
                    title="Delete?"
                    @confirm="deleteItem(index)"
                    okText="Yes"
                    cancelText="No"
                  >
                    <a href="#">Delete</a>
                  </a-popconfirm>
                  <a-list-item-meta>
                    <a slot="title">{{item.codeean13.slice(0,30)}}</a>
                  </a-list-item-meta>
                </a-list-item>
              </a-list>
            </div>
          </a-col>
          <a-col>
            <a-button type="primary" @click="createShip" block>Create invoice</a-button>
          </a-col>
        </a-row>
      </a-col>
    </a-row>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "CreateShipment",
  data: function() {
    return {
      data: [],
      code: "",
      barcode: null,
      viewBarcode: false,
      visible: true,
      invoice: ""
    };
  },
  components: {
    // Barcode
  },
  mounted() {
    this.selectInput();
  },
  methods: {
    ...mapActions(["addInvoice"]),
    setCode(val) {
      this.code = val;
    },
    getInvoice() {
      return this.invoice;
    },
    setBarcode(val) {
      this.barcode = val;
    },
    createShip() {
      if (this.getInvoice().length === 0) {
        this.$message.warning("Input Invoice number");
        return;
      }
      if (this.getData().length > 0) {
        const data = {
          data: this.getData(),
          invoice: this.getInvoice()
        };
        this.addInvoice(data).then(
          res => {
            this.$message.success("Shipment completed successfully");
          },
          res => {
            this.$message.error("Check ean13 codes or invoice number");
          }
        );
      } else this.$message.warning("Input DM code");
    },
    getData() {
      return this.data;
    },
    getCode() {
      return this.code;
    },
    addData(code) {
      console.log(code.slice(0, 12));

      this.getData().push({
        codeean13: code.slice(0, 12)
      });
    },
    endInputCode() {
      if (this.findDuplicate(this.getCode())) {
        this.$message.warning("Is ean13 code exist");
      } else {
        this.addData(this.getCode());
        this.selectInput();
      }
    },
    selectInput() {
      this.$refs.addEAN.focus();
      this.$refs.addEAN.select(true);
    },
    findDuplicate(code) {
      let duplicate = false;
      this.getData().forEach(item => {
        if (item.codeean13 === code) {
          duplicate = true;
        }
      });
      return duplicate;
    },
    deleteItem(id) {
      this.getData().splice(id, 1);
    }
  }
};
</script>

<style>
.package {
  width: 700px;
  padding: 20px;
}
.demo-infinite-container {
  margin-top: 10px;
  border: 1px solid #e8e8e8;
  border-radius: 4px;
  overflow: auto;
  padding: 8px 24px;
  height: 300px;
  margin-bottom: 10px;
}
.barcode {
  margin-top: 15px;
}
.invoice {
  margin-bottom: 10px;
}
</style>
