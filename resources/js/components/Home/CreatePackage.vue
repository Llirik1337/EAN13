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
            <a-table :columns="columns" :data-source="data">
                <a slot="name" slot-scope="text">{{ text }}</a>
                <a slot="codedm" slot-scope="text">{{ text }}</a>
                <a slot="actions" slot-scope="text, record, index">
                <a-popconfirm
                    title="Delete?"
                    @confirm="deleteItem(index)"
                    okText="Yes"
                    cancelText="No"
                >
                    <a href="#">Delete</a>
                </a-popconfirm>
                </a>
            </a-table>
        <a-button type="primary" @click="createPackage" block>Create package</a-button>
        <a-button type="primary" style="margin-top: 1px;" @click="store" block>Store package</a-button>
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
      viewBarcode: false,
        columns: [
            {
                title: 'DM code',
                dataIndex: 'codedm',
                key: 'codedm',
                scopedSlots: { customRender: 'codedm' },
            },
            {
                title: 'Info',
                dataIndex: 'info',
                key: 'info',
                scopedSlots: { customRender: 'info' },
                width: 300,
            },
            {
                title: 'Status',
                dataIndex: 'status',
                key: 'status',
                scopedSlots: { customRender: 'status' },
                width: 150,
            },
            {
                title: 'Actions',
                dataIndex: 'actions',
                key: 'actions',
                scopedSlots: { customRender: 'actions' },
                width: 150,
            },
        ]
    };
  },
  components: {
    Barcode
  },
  mounted() {
    this.selectInput();
  },
  methods: {
    ...mapActions(["addPackage", "storePackage"]),
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
    async store() {
        try {
            if (this.getData().length > 0) {
                const res = await this.storePackage(this.getData());
                this.hideBarcode();
                this.setBarcode(res.toString());
                this.showBarcode();
                this.$message.success("Package successfully stored");
                this.data = []
            } else this.$message.warning("Input DM code");
        } catch (e) {
            console.log(e)
        }
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
            this.data = []
          },
            ({errors, codedms}) => {
              errors.map(item=> {
                  let code;
                  if(typeof item === 'object') {
                      code = item.DM.code.slice(0, 31)
                  }
                  else {
                      code = item.DM;
                  }
                  this.getCodedm(code).status = 'Error';
                  this.getCodedm(code).info = item.msg;
              })
                codedms.map(item=> {
                    const code = item.code.slice(0,31)
                  this.getCodedm(code).status = 'Success';
                    this.getCodedm(code).info = 'Ready';
              })

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
        codedm: code,
          status: '-',
          info: ''
      });
    },
      getCodedm(codedm) {
        return  this.data.find(item=> {
            if(item.codedm === codedm)
                return item;
        })
      },
    endInputCode() {
      if (this.getCodedm(this.getCode())) {
        this.$message.warning("Is datamatrix code exist in this package");
      } else {
        this.addData(this.getCode().slice(0,31));
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
