<template>
    <div>
        <div v-for="item in codes" class="new-page">
            <barcode-print-field
                :key="Math.random()"
                :template="barcodeTemplate"
                :data="convertToTemplateData(item)"
            >
            </barcode-print-field>
        </div>
    </div>
</template>

<script>
import Barcode from "../Search/Barcode";
import BarcodePrintField from "../BarcodePrintField";

export default {
    components: {
        BarcodePrintField,
        Barcode,
    },
    props: {
        barcodeTemplate: {
            type: Object,
        },
        codeean: {
            type: String,
            default: "",
        },
        codes: {
            type: Array,
            required: true,
        },
        tovarName: {
            type: String,
            required: true,
        },
        description: {
            type: String,
        },
        hasEAC: {
            type: Boolean,
        },
        innerCode: {
            type: String,
        },
    },
    mounted() {
        this.$nextTick(function () {
            setTimeout(() => this.$emit("render"), 1000);
        });
    },
    methods: {
        convertToTemplateData(item) {
            const invisebleChar = String.fromCharCode(29);

            const code = item.code;

            const value =
                code.slice(0, 31) +
                invisebleChar +
                code.slice(32, 37) +
                invisebleChar +
                code.slice(37);
            const convertedToData = {
                value,
                codeean: this.codeean,
                tovarName: this.tovarName,
                description: this.description,
                hasEAC: this.hasEAC,
                innerCode: this.innerCode,
            };
            // console.log('this.description -> ', this.description)
            // console.log('this.innerCode -> ', this.innerCode)
            // console.log('this.hasEAC -> ', this.hasEAC)
            // console.log('convertedToData -> ', convertedToData);
            return convertedToData;
        },
    },
};
</script>

<style scoped></style>
