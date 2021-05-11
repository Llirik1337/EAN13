<template>
    <div
        :key="Math.random()"
        style="font-size:8pt;  height: 57mm; padding-top: 5px"
        class="new-page"
    >
        {{ this.codeean }}
        <table width="500">
            <tr>
                <td class="tovar" width="30%">
                    {{ this.tovarName }}
                </td>
                <td width="70%">
                    <canvas
                        ref="barcode"
                        style="width: 35mm; height: 35mm;"
                    ></canvas>
                </td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="70%" :style="`font-size:8pt;`">
                    {{ this.code15 }}
                </td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="70%">{{ this.code16 }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import bwipjs from "bwip-js";
export default {
    props: {
        data: {
            type: Object,
            requred: true
        }
    },
    data: function() {
        return {
            code15: "",
            code16: "",
            codeean: "",
            value: "",
            tovarName: "",
            fontWidth: "",
            fontSize: ""
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
            const {
                codeean,
                value,
                tovarName,
                fontWidth,
                fontSize
            } = this.data;
            this.codeean = codeean;
            this.value = value;
            this.tovarName = tovarName;
            this.fontWidth = fontWidth;
            this.fontSize = fontSize;

            if (this.value === null || this.tovarName === null) return;
            this.setCode31();
            this.generateBarcode(this.value);
        },
        setCode31() {
            this.code15 =
                "(" + this.value.slice(0, 2) + ")" + this.value.slice(2, 15);
            this.code16 = this.value.slice(15, 31);
        },
        /**
         * @param {String} value
         **/
        generateBarcode(value) {
            try {
                bwipjs.toCanvas(this.$refs.barcode, {
                    bcid: "datamatrix",
                    scale: 4,
                    text: value
                });
            } catch (e) {
                console.log(e);
            }
        }
    }
};
</script>
