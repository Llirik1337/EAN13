<template>
    <div>
        <div style="margin: 5px">
            <a-button @click="printAll()">Print all free DM Codes</a-button>
            <select-barcode-template :templates-list-title="barcodeTemplateNameList"
                                     @change="globalChangeBarcodeTemplate"></select-barcode-template>
        </div>
        <a-table
            :dataSource="tableData"
            :rowKey="record => record.code"
            :columns="columns"
            :loading="loadingData"
            size="large"
        >
            <template slot="action" slot-scope="text, record">
                <select-barcode-template :templates-list-title="barcodeTemplateNameList"
                                         @change="changeBarcodeTemplate"></select-barcode-template>
                <print-action
                    @print="
                        count => getAll(record, count)
                    "
                />
            </template>
        </a-table>
        <a-modal title="Printed" :visible="print" @cancel="print = false">
            <template slot="footer">
                <a-button key="back" @click="print = false">
                    Cancel
                </a-button>
                <a-button @click.stop="printBarcode()">Print</a-button>
            </template>
            <div id="print">
                <!--                <barcodes v-if="print" v-for="(item,key) in toPrint" :key="Math.random()" :codes="item.codes" :tovar-name="item.tovarName" :after-render="printBarcode" :codeean="key"></barcodes>-->
                <barcodes
                    v-if="print"
                    v-for="item in toPrint"
                    :key="Math.random()"
                    :codes="item.codes"
                    :has-e-a-c="item.Certification ? true : false"
                    :description="item.description"
                    :barcode-template="currentBarcodeTemplate"
                    :inner-code="item.innerCode"
                    :tovar-name="item.tovarName"
                    @render="printBarcode"
                    :codeean="item.codeean"
                ></barcodes>
            </div>
        </a-modal>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import printJS from "print-js";
import ModalBarcodes from "./Statistics/modalBarcodes";
import Barcodes from "./Statistics/Barcodes";
import PrintAction from "./Statistics/PrintAction";
import defaultTemplate from "./BarcodesTemplate/default";
import newTemplate from "./BarcodesTemplate/new";
import SelectBarcodeTemplate from "./SelectBarcodeTemplate";

const defaultTemplatePrintConfig = {
    printable: "print",
    type: "html",
    style: `
        @page {
           size: Letter landscape;
           size: 58mm 40mm;
           margin: 0px;
          }
          @media print {
          *{
          font-size: 11pt;
          }
          }`,
};

const newTemplatePrintConfig = {
    printable: "print",
    type: "html",
    style: `
        @page {
           size: Letter landscape;
           size: 58mm 80mm;
           margin: 0px;
          }
          @media print {
          *{
          font-size: 7pt;
          }
          img {
            float: right;
          }
          }`,
};

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
        scopedSlots: {customRender: "action"},
        width: "400px"
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
    components: {SelectBarcodeTemplate, PrintAction, Barcodes, ModalBarcodes},
    data: function () {
        return {
            barcodeTemplateNameList: ['old(58*40)', 'new(58*80)'],
            barcodeTemplateList: [defaultTemplate, newTemplate],
            barcodeTemplatePrintConfigList: [defaultTemplatePrintConfig, newTemplatePrintConfig],
            currentBarcodeTemplate: defaultTemplate,
            currentPrintConfig: defaultTemplatePrintConfig,
            globalCurrentBarcodeTemplate: defaultTemplate,
            globalCurrentPrintConfig: defaultTemplatePrintConfig,
            tableData: [],
            columns,
            loadingData: true,
            toPrint: [],
            tovarName: null,
            codeean: "",
            print: false
        };
    },
    watch: {
        toPrint() {
            console.log('this.toPrint -> ', this.toPrint);
        }
    },
    async mounted() {
        await this.updateData();
    },
    computed: {
        ...mapGetters(["getStatistics"])
    },
    methods: {
        ...mapActions([
            "updateStatistics",
            "getAllDMCodes",
            "setStatus",
            "getAllFreeDMCode"
        ]),
        changeBarcodeTemplate(templateIndex) {
            this.currentBarcodeTemplate = this.barcodeTemplateList[templateIndex];
            this.currentPrintConfig = this.barcodeTemplatePrintConfigList[templateIndex];
        },
        globalChangeBarcodeTemplate(templateIndex) {
            this.globalCurrentBarcodeTemplate = this.barcodeTemplateList[templateIndex];
            this.globalCurrentPrintConfig = this.barcodeTemplatePrintConfigList[templateIndex];
        },
        async updateData() {
            this.loadingData = true;
            await this.updateStatistics();
            this.tableData = this.getStatistics;
            this.loadingData = false;
        },
        async printAll() {
            try {
                const res = await this.getAllFreeDMCode();
                console.log(res);
                this.toPrint = [];
                this.toPrint = res;
                this.print = true;
                console.log('this.toPrint -> ', this.toPrint);
            } catch (e) {
                console.log(e.massage);
            }
        },
        async printBarcode() {
            try {
                printJS(this.currentPrintConfig);
                for (const toPrintElement of this.toPrint) {
                    for (const code of toPrintElement.codes) {
                        // console.log(code);
                        const res = await this.setStatus({
                            codedm_id: code.id,
                            status: "Print"
                        });
                    }
                }
            } catch (e) {
                console.log(e.massage);
            }
        },
        async getAll(record, count) {
            try {
                this.toPrint = [];
                let res;
                console.log('record -> ', record);
                if (!count) {
                    res = await this.getAllDMCodes({codeean: record.code});
                } else {
                    res = await this.getAllDMCodes({codeean: record.code, count});
                }
                console.log('res -> ', res);
                if (!res.length) return;
                this.toPrint = [{
                    codeean: record.code,
                    codes: res,
                    tovarName: record.tovarname,
                    description: record.description,
                    innerCode: record.innerCode,
                    Certification: record.Certification
                }];
                this.print = true;
            } catch (e) {
                console.log(e);
            }
        }
    }
};
</script>

<style scoped></style>
