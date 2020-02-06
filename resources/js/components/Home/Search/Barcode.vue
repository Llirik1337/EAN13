<template>
  <div>
    <div ref="barcode" id="print">
      <div style="width:150mm; font-size: 8pt;">
        <a-row type="flex">
          <a-col :span="24">
            <a-row type="flex">
              <a-col :span="6">{{ this.tovarName }}</a-col>
              <a-col>
                <canvas id="barcode" style="width: 100px; height: 100px"></canvas>
              </a-col>
            </a-row>
            <a-row type="flex">
              <a-col :offset="6">{{ this.code15 }}</a-col>
            </a-row>
            <a-row type="flex">
              <a-col :offset="6">{{ this.code16 }}</a-col>
            </a-row>
          </a-col>
        </a-row>
      </div>
    </div>
    <a-button type="primary" @click="printBarcode">Print</a-button>
  </div>
</template>

<script>
import bwipjs from "bwip-js";
import printJS from "print-js";

import { mapActions, mapGetters } from "vuex";
export default {
  props: ["value", "tovarName", "toPrint"],
  data: function() {
    return {
      // canvas: null
      code15: "",
      code16: ""
    };
  },
  created: function() {
    this.$parent.$on("print", this.printBarcode);
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
      if (this.value == null || this.tovarName == null) return;
      this.generateBarcode(this.value);
      this.printBarcode();
      this.setCode31();
    },
    setCode31() {
      this.code15 =
        "(" + this.value.slice(0, 2) + ")" + this.value.slice(2, 15);
      this.code16 = this.value.slice(15, 31);
    },

    printBarcode() {
      printJS({
        printable: "print",
        type: "html",
        style: `@page {
           size: Letter landscape;
           size: 57mm 40mm;
           margin: 0px;
          }`
      });
    },

    generateBarcode(value) {
      bwipjs.toCanvas("barcode", {
        bcid: "gs1datamatrix",
        text: this.modValue(value),
        height: 100,
        includetext: true,
        textxalign: "center"
      });
    },
    modValue(value) {
      return "\x1D" + value.slice(0, 2) + ")" + value.slice(2);
    }
  }
};
</script>

<style></style>
