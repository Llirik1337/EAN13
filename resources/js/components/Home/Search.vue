<template>
    <a-row class="form" justify="center" type="flex" v-if="this.user">
        <a-col :span="20">
            <a-form
                :labelCol="formCol.label"
                :wrapperCol="formCol.wrapper"
                :form="form"
                @submit="submit"
                layout="vertical"
            >
                <a-form-item label="Company">{{
                        user.company.name
                    }}
                </a-form-item>
                <a-form-item label="Cargo number" v-if="!user.company.external">
                    <a-auto-complete
                        :data-source="getExternalsNumbers"
                        v-model="selectCargo"
                    ></a-auto-complete>
                </a-form-item>
                <a-form-item label="Printing directly to the printer">
                    <a-checkbox :disabled="!getEnabled" v-model="toPrint"/>
                </a-form-item>
                <a-form-item label="Print settings">
                    <select-barcode-template :templates-list-title="barcodeTemplateNameList"
                                             @change="changeBarcodeTemplate"></select-barcode-template>
                </a-form-item>
                <a-form-item label="EAN13">{{ getCodeEAN13Msg() }}</a-form-item>
                <a-form-item label="Code">
                    <a-input
                        :disabled="!getEnabled"
                        :placeholder="getState()"
                        ref="code"
                        :addonBefore="getState()"
                        v-model="code"
                        @pressEnter="endInputCode"
                        :allowClear="true"
                        :help="getHelpInputCode"
                    >
                    </a-input>
                </a-form-item>
                <a-form-item label="Result">
                    <p>{{ resultMsg }}</p>
                    <div v-if="viewBarcode">
                        <barcode-print-field
                            id="print"
                            :template="currentBarcodeTemplate"
                            :data="getBarcodeData"
                        ></barcode-print-field>
                        <!--                        <barcode-->
                        <!--                            id="print"-->
                        <!--                            :tovarName="getCodeEAN13().tovarname"-->
                        <!--                            :codeean="code"-->
                        <!--                            :value="getCodeDM().code"-->
                        <!--                            :font-size="fontSize"-->
                        <!--                            :font-width="fontWeight"-->
                        <!--                        ></barcode>-->
                        <a-button type="primary" @click="printBarcode"
                        >Print
                        </a-button
                        >
                    </div>
                </a-form-item>
            </a-form>
        </a-col>
    </a-row>
</template>
<script>
import {mapActions, mapGetters} from "vuex";
import printJS from "print-js";
import Barcode from "./Search/Barcode";
import PreviewBarcode from "./Search/PreviewBarcode";
import SelectBarcodeTemplate from "./SelectBarcodeTemplate";
import defaultTemplate from "./BarcodesTemplate/default";
import newTemplate from "./BarcodesTemplate/new";
import BarcodePrintField from "./BarcodePrintField";


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

export default {
    name: "Search",
    data() {
        return {
            barcodeTemplateNameList: ['old(58*40)', 'new(58*80)'],
            barcodeTemplateList: [defaultTemplate, newTemplate],
            barcodeTemplatePrintConfigList: [defaultTemplatePrintConfig, newTemplatePrintConfig],
            currentBarcodeTemplate: defaultTemplate,
            currentPrintConfig: defaultTemplatePrintConfig,
            formCol: {
                label: {
                    span: 3,
                },
                wrapper: {
                    span: 20,
                },
            },
            States: {
                EAN13: {
                    EAN13Msg: "",
                    EAN13: null,
                    prefix: "EAN13",
                    help: "Input code EAN13",
                },
                DM: {
                    codedm: null,
                    help: "Input code EAN13",
                },
            },
            previewBarcodeVisible: false,
            user: null,
            toPrint: false,
            code: "",
            resultMsg: "",
            viewBarcode: false,
            isEndInputCode: false,
            state: "EAN13",
            validateDM: false,
            help: "",
            selectCargo: null,
            fontSize: 8,
            fontWeight: "normal",
        };
    },
    provide: function () {
        return {
            hidePreviewBarcode: this.hidePreviewBarcode,
        };
    },
    components: {
        BarcodePrintField,
        Barcode,
        PreviewBarcode,
        SelectBarcodeTemplate
    },
    beforeMount() {
        this.user = this.getUser;
        this.selectCargo = this.getSelectedCargo;
        this.form = this.$form.createForm(this, {name: "search"});
    },
    mounted() {
        this.Init();
        console.log(this.getExternalsNumbers);
    },
    computed: {
        ...mapGetters(["getUser", "getSelectedCargo"]),
        getBarcodeData() {
            return {
                tovarName: this.getCodeEAN13().tovarname,
                description: this.getCodeEAN13().description,
                hasEAC: this.getCodeEAN13().Certification ? true : false,
                innerCode: this.getCodeEAN13().innerCode,
                codeean: this.code,
                value: this.getCodeDM().code,
                "font-size": this.fontSize,
                "font-width": this.fontWeight
            }
        },
        getExternalsNumbers() {
            if (this.user.company.codeean13) {
                const defaultCargo = [{text: "Нет", value: "-1"}];
                for (const ean of this.user.company.codeean13) {
                    for (const {number: text, id: value} of ean.cargo) {
                        defaultCargo.push({text, value: value.toString()});
                    }
                }
                const uniqueArray = (a) =>
                    [...new Set(a.map((o) => JSON.stringify(o)))].map((s) =>
                        JSON.parse(s)
                    );
                return uniqueArray(defaultCargo);
            }
            return [];
        },
        getEnabled() {
            return (
                this.user.company.external !== 0 || this.selectCargo !== null
            );
        },
    },
    watch: {
        selectCargo() {
            this.updateSelectedCargo(this.selectCargo);
        },
    },
    methods: {
        ...mapActions([
            "searchCodeEan13",
            "searchCodeDMByCode",
            "searchCodeDM",
            "updateSelectedCargo",
        ]),
        changeBarcodeTemplate(templateIndex) {
            // console.log('templateName -> ', templateIndex);
            this.currentBarcodeTemplate = this.barcodeTemplateList[templateIndex];
            this.currentPrintConfig = this.barcodeTemplatePrintConfigList[templateIndex];
        },
        printBarcode() {
            printJS(this.currentPrintConfig);
            this.selectInput();
        },
        getEAN13Help() {
            return this.States.EAN13.help;
        },
        getDMHelp() {
            return this.States.DM.help;
        },

        getHelpInputCode() {
            switch (this.getState()) {
                case "DM":
                    return this.getDMHelp();
                    break;
                case "EAN13":
                    return this.getEAN13Help();
                    break;
            }
        },

        showPreviewBarcode() {
            this.previewBarcodeVisible = true;
        },
        hidePreviewBarcode() {
            this.previewBarcodeVisible = false;
        },
        // hidePreviewBarcode() {
        //     this.previewBarcodeVisible = false;
        // },

        inRange(val, min, max, left = false, right = false) {
            let resultLeft;
            let resultRight;
            if (left) {
                resultLeft = min > val;
            } else {
                resultLeft = min >= val;
            }

            if (right) {
                resultRight = val < max;
            } else {
                resultRight = val <= max;
            }

            return resultLeft && resultRight;
        },
        selectInput() {
            this.$refs.code.focus();
            this.$refs.code.select(true);
        },
        setNextStep() {
            // console.log(this.getState());

            switch (this.getState()) {
                case "EAN13":
                    this.state = "DM";
                    break;
                case "DM":
                    this.state = "EAN13";
                    break;
            }

            // console.log(this.getState());
        },

        hideBarcode() {
            // console.log(this.viewBarcode);

            this.viewBarcode = false;
        },

        showBarcode() {
            this.viewBarcode = true;
        },
        toggleBarcode() {
            this.viewBarcode = !this.viewBarcode;
        },

        clearEAN13() {
            this.States.EAN13.EAN13Msg = "None";
        },

        getEAN13msg() {
            return this.States.EAN13.EAN13Msg;
        },

        getCode() {
            return this.code;
        },

        getToPrint() {
            return this.toPrint;
        },

        previewBarcode() {
            if (!this.getToPrint()) {
                this.showPreviewBarcode();
            } else {
                this.setResultMsg("DataMatrix code sent for printing");
            }
        },

        endInputCode() {
            if (
                /*this.inRange(this.getCode().length, 13, 15) &&*/
                this.eqState("EAN13")
            ) {
                this.hideBarcode();
                this.findCodeEan13(this.getCode()).then((res) => {
                    this.previewBarcode();
                    if (this.getToPrint()) {
                        this.printBarcode();
                    }
                    this.selectInput();
                    this.setNextStep();
                });
            }
            if (/*this.getCode().length >= 127 && */ this.eqState("DM")) {
                console.log(this.viewBarcode);

                console.log(this.checkDM(this.getCode()));

                if (this.checkDM(this.getCode()))
                    this.findCodeDm(this.getCode()).then((res) => {
                        this.setNextStep();
                        this.hideBarcode();
                    });
                else {
                    this.setResultMsg(
                        "DataMatrix codes do not match. Please repeat"
                    );
                }
                this.selectInput();
            }
        },

        getState() {
            return this.state;
        },
        eqState(val) {
            return this.state === val;
        },

        focusInput() {
            this.$refs.code.focus();
        },
        Init() {
            this.clearEAN13();
            this.focusInput();
        },
        findCodeDm(val) {
            return new Promise((resolve, reject) => {
                try {
                    this.searchCodeDMByCode(val).then(
                        (result) => {
                            let msg;
                            let res;
                            if (
                                result.data.codedm !== null &&
                                result.data.codedm !== undefined
                            ) {
                                res = result.data.codedm;

                                this.setCodeDM(res);
                                this.setCodeEAN13Msg(res.codeean13.code);
                                //   this.States.EAN13.EAN13Msg = res.codeean13.code;
                                if (res.status_id !== null) {
                                    msg = `code: ${res.code} \n\r change status to ${res.status.name}`;
                                } else {
                                    msg = "This code is not printed.";
                                }
                            } else {
                                msg = "I did not find the DM code";
                            }

                            this.setResultMsg(msg);
                            //   this.resultMsg = msg;
                            resolve();
                        },
                        (res) => {
                            reject();
                        }
                    );
                } catch (exeption) {
                    // console.log(exeption);
                }
            });
        },

        checkDM(val) {
            if (this.isAliveDM()) {
                return this.getCodeDM().code == val;
            }
            return false;
        },

        setCodeDM(val) {
            this.States.DM.codedm = val;
        },

        getCodeDM() {
            return this.States.DM.codedm;
        },

        isAliveDM() {
            return this.getCodeDM() !== null;
        },

        isAliveEAN13() {
            return this.getCodeEAN13() !== null;
        },

        setCodeEAN13(val) {
            this.States.EAN13.EAN13 = val;
        },
        getCodeEAN13() {
            return this.States.EAN13.EAN13;
        },
        setCodeEAN13Msg(val) {
            // console.log(val);

            this.States.EAN13.EAN13Msg = val;
        },
        getCodeEAN13Msg() {
            return this.States.EAN13.EAN13Msg;
        },

        getResultMsg() {
            return this.resultMsg;
        },

        setResultMsg(val) {
            this.resultMsg = val;
        },

        async findCodeEan13(code) {
            try {
                const result = await this.searchCodeEan13({
                    code,
                    cargo_id: this.selectCargo,
                });

                this.setCodeEAN13(result);
                this.setCodeEAN13Msg(result.code);
                try {
                    const res = await this.searchCodeDM(this.getCodeEAN13().id);
                    this.setCodeDM(res);
                    this.showBarcode();
                } catch (e) {
                    this.setCodeEAN13Msg("did’t find free DM");
                }
            } catch (e) {
                this.setCodeEAN13Msg("this EAN is not registered");
            }
        },

        setToPrint(val) {
            this.toPrint = val;
        },

        changePrint({target}) {
            //   this.toPrint = target.checked;
            this.setToPrint(target.checked);
        },
        submit(e) {
            e.preventDefault();
            // console.log();
        },
    },
};
</script>
<style>
.form {
    background-color: #fff;
    padding: 24px;
}

.input-state {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10pt;
}

.ant-form-item {
    margin-bottom: 0px;
}
</style>
