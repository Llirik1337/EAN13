<template>
    <div :key="Math.random()" style="font-size:6pt; height: 117mm;" class="more">
        <table width="280">
            <tr>
                <td colspan="2">
                    {{ this.codeean }}
                </td>
            </tr>
            <tr>
                <td width="100px" class="tovar">
                    {{ this.tovarName }}
                </td>
                <td width="70%" style="float:right">
                    <canvas
                        ref="barcode"
                        style="width: 35mm; height: 35mm;"
                    ></canvas>
                </td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="70%" :style="`float:right;`">
                    {{ this.code15 }}
                </td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="70%" :style="`float:right;`">{{ this.code16 }}</td>
            </tr>
            <tr style="height: 50mm">
                <td width="100%" colspan="2">
                    {{ this.description }}
                </td>
            </tr>
            <tr>
                <td width="30%">
                    <canvas
                        ref="innerEANCode"
                        style="width: 35mm"
                    ></canvas>
                <td width="70%">
                    <img style="float:right" v-if="this.hasEAC" src="eac.png" height="30mm" width="60mm"/>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import bwipjs from "bwip-js";

export default {
    name: "new",
    props: {
        data: {
            type: Object,
            requred: true,
        },

    },
    data: function () {
        return {
            code15: "",
            code16: "",
            codeean: "",
            value: "",
            tovarName: "",
            description: "",
            innerCode: "",
            hasEAC: false
        };
    },
    updated() {
        this.init();
    },
    mounted() {
        this.init();
    },
    methods: {
        ...mapActions(["getBarcode"]),
        init() {
            const {codeean, value, tovarName, description, hasEAC, innerCode} = this.data;
            this.codeean = codeean;
            this.value = value
            this.tovarName = tovarName
            this.description = description
            this.hasEAC = hasEAC
            this.innerCode = innerCode
            console.log(this.data);
            if (this.value === null || this.tovarName === null) return;
            this.setCode31();
            this.generateBarcode(this.value);
            this.generateInnerEANCode(this.innerCode);
        },
        setCode31() {
            this.code15 =
                "(" + this.value.slice(0, 2) + ")" + this.value.slice(2, 15);
            this.code16 = this.value.slice(15, 31);
        },
        generateBarcode(value) {
            if (!value) return;
            try {
                bwipjs.toCanvas(this.$refs.barcode, {
                    bcid: "datamatrix",
                    scale: 4,
                    text: value
                });
            } catch (e) {
                console.log(e);
            }
        },
        generateInnerEANCode(value) {
            if (!value) return;
            try {
                bwipjs.toCanvas(this.$refs.innerEANCode, {
                    bcid: "ean13",
                    scale: 5,
                    height: 8,              // Bar height, in millimeters
                    text: value,
                    includetext: true,            // Show human-readable text
                    textxalign: 'center',        // Always good to set this
                });
            } catch (e) {
                console.log(e);
            }
        }
    }
}
</script>
<style>
@media print {
    .more {
        page-break-after: always;
    }
}
</style>
<!--<style scoped>-->

<!--</style>-->
