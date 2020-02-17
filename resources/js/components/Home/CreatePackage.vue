<template>
  <div>
    <a-row type="flex" justify="center">
      <a-col class="package" :span="12">
        <a-input
          ref="addDM"
          placeholder="Input datamatrix"
          v-model="code"
          @pressEnter="endInputCode"
        ></a-input>
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
                <a slot="title">{{item.codedm.slice(0,30)}}</a>
              </a-list-item-meta>
            </a-list-item>
          </a-list>
        </div>
        <a-button type="primary" @click="createPackage" block>Create package</a-button>
      </a-col>
    </a-row>
    <a-row type="flex" justify="center" class="barcode">
      <a-col v-if="viewBarcode">
        <barcode id="print" :value="barcode"></barcode>
        <a-button type="primary" @click="printBarcode" block>Print</a-button>
      </a-col>
    </a-row>
  </div>
</template>

<script>
import Barcode from "./CreatePackage/Barcode";
import printJS from "print-js";
import { mapActions } from "vuex";
export default {
  name: "CreatePackage",
  data: function() {
    return {
      data: [],
      code: "",
      barcode: null,
      viewBarcode: false
    };
  },
  components: {
    Barcode
  },
  mounted() {
    this.selectInput();
  },
  methods: {
    ...mapActions(["addPackage"]),
    getViewBarcode() {
      return this.viewBarcode;
    },
    printBarcode() {
      printJS({
        printable: "print",
        type: "html",
        style: `
        @page {

           size: Letter landscape;
           size: 57mm 40mm;
           margin: 0px;
          }`
      });
    },
    setViewBarcode(val) {
      this.viewBarcode = val;
    },
    showBarcode() {
      this.setViewBarcode(true);
    },
    hideBarcode() {
      this.setViewBarcode(false);
    },

    setCode(val) {
      this.code = val;
    },

    setBarcode(val) {
      this.barcode = val;
    },

    createPackage() {
      if (this.getData().length > 0)
        this.addPackage(this.getData()).then(
          res => {
            this.hideBarcode();
            console.log(res);
            this.setBarcode(res.toString());
            this.showBarcode();
            this.$message.success("Package successfully created");
          },
          res => {
            this.$message.error(
              "Failed to create package. Check datamatrix codes"
            );
          }
        );
      else this.$message.warning("Input DM code");
    },
    getData() {
      return this.data;
    },
    getCode() {
      return this.code;
    },
    addData(code) {
      this.getData().push({
        codedm: code
      });
    },
    endInputCode() {
      if (this.findDuplicate(this.getCode())) {
        this.$message.warning("Is datamatrix code exist in this package");
      } else {
        this.addData(this.getCode());
        this.selectInput();
      }
    },
    selectInput() {
      this.$refs.addDM.focus();
      this.$refs.addDM.select(true);
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
</style>
