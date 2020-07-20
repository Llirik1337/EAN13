<template>
    <div>
        <a-button @click="printAll()">Print all free DM Codes</a-button>
      <a-table
        :dataSource="tableData"
        :rowKey="record => record.code"
        :columns="columns"
        :loading="loadingData"
      >
          <template slot="action" slot-scope="text, record">
              <a-button @click="getAll(record.code, record.tovarname)">Print all DM code</a-button>
          </template>
      </a-table>
        <a-modal title="Printed" :visible="print" @cancel="print = false">
            <template slot="footer">
                <a-button key="back" @click="print = false">
                    Cancel
                </a-button>
                <a-button @click.stop="printBarcode()">Print</a-button>
            </template>
            <div id="print" >
<!--                <barcodes v-if="print" v-for="(item,key) in toPrint" :key="Math.random()" :codes="item.codes" :tovar-name="item.tovarName" :after-render="printBarcode" :codeean="key"></barcodes>-->
                <barcodes v-if="print" v-for="(item) in toPrint" :key="Math.random()" :codes="item.codes" :tovar-name="item.tovarName" :after-render="printBarcode" :codeean="item.eancode"></barcodes>
            </div>
        </a-modal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import printJS from "print-js";
import ModalBarcodes from "./Statistics/modalBarcodes";
import Barcodes from "./Statistics/Barcodes";

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
        title: "Functions",
        scopedSlots: { customRender: 'action' },
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
    components: {Barcodes, ModalBarcodes},
    data: function() {
    return {
      tableData: [],
      columns,
      loadingData: true,
      toPrint: [],
        tovarName: null,
        codeean: '',
        print: false,
    };
  },

  async mounted() {
    await this.updateData();
  },
  computed: {
    ...mapGetters(["getStatistics"])
  },
  methods: {
    ...mapActions(["updateStatistics",'getAllDMCodes', 'setStatus', 'getAllFreeDMCode']),
      async updateData() {
        this.loadingData = true;
          await this.updateStatistics()
          this.tableData = this.getStatistics;
          this.loadingData = false;
      },
      async printAll() {
          try {
              const res = await this.getAllFreeDMCode();
              console.log(res);
              this.toPrint= [];
              this.toPrint =res;
              // for (const [ean, data] of Object.entries(res)) {
              //     console.log(ean, data)
              //     this.toPrint[ean] = data
              // }
              this.print = true;
              console.log(this.toPrint);
          } catch (e) {
              console.log(e.massage)
          }
      },
      async printBarcode() {
        try {
            printJS({
                printable: "print",
                type: "html",
                style: `
              @page {
                    size: Letter landscape;
                    size: 57mm 40mm;
                    margin: 0px;
              }
              @media print {*{
                        page-break-after: always;
                        font-size: 8pt;
                        }
                    }
                `
            });
            for (const toPrintElement of this.toPrint) {
                for (const code of toPrintElement.codes) {
                    console.log(code);
                    const res = await this.setStatus({codedm_id: code.id, status: 'Print'});
                }
            }
        } catch (e) {
            console.log(e.massage);
        }
      },
      async getAll(eancode,tovarName) {
        try {
            this.toPrint= [];
          const res = await this.getAllDMCodes(eancode);
          if(!res.length) return;
          this.toPrint = [{eancode,codes: res, tovarName}];
          this.print = true
            console.log(this.toPrint);
        } catch (e) {
            console.log(e.massage);
        }
      }
  }
};
</script>

<style scoped>
</style>
