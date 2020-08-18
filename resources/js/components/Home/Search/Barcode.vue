<template>
    <div :key="Math.random()" :style="`font-size:8pt;`">
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
import bwipjs from "bwip-js";

import { mapActions, mapGetters } from "vuex";
export default {
    props: {
        codeean: {
            type: String,
            required: true
        },
        value: {
            required: true,
            type: String
        },
        tovarName: {
            required: true,
            type: String
        },
        fontWidth: {
            type: String,
            default: "normal"
        },
        fontSize: {
            type: Number,
            default: 8
        }
    },
    data: function() {
        return {
            code15: "",
            code16: ""
        };
    },
    updated() {
        this.init();
    },
    mounted() {
        console.log(this.tovarName);
        console.log(this.codeean);
        this.init();
    },
    methods: {
        ...mapActions(["getBarcode"]),

        init() {
            if (this.value == null || this.tovarName == null) return;
            this.generateBarcode(this.value);
            this.setCode31();
        },
        setCode31() {
            this.code15 =
                "(" + this.value.slice(0, 2) + ")" + this.value.slice(2, 15);
            this.code16 = this.value.slice(15, 31);
        },

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
