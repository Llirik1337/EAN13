<template>
  <div ref="barcode">
    <div>
      <table>
        <tr>
          <td>{{ this.tovarName }}</td>
          <td><canvas id="barcode" style="width: 40mm; height: 40mm"></canvas></td>
        </tr>
        <tr>
          <td></td>
          <td>{{ this.code15 }}</td>
        </tr>
        <tr>
          <td></td>
          <td>{{ this.code16 }}</td>
        </tr>
      </table>

      <!-- <a-row>
        <a-col :span="12">{{ this.tovarName }}</a-col>
        <a-col :span="12">
          <canvas id="barcode" style="width: 20mm; height: 20mm"></canvas>
        </a-col>
        <a-col :offset="12" :span="12">{{ this.code15 }}</a-col>
        <a-col :offset="12" :span="12">{{ this.code16 }}</a-col>
      </a-row>-->
    </div>
  </div>
</template>

<script>
import bwipjs from "bwip-js";

import { mapActions, mapGetters } from "vuex";
export default {
  //   props: ["value", "tovarName", "preview"],
  props: {
    value: {
      required: true,
      type: String
    },
    tovarName: {
      required: true,
      type: String
    }
  },
  data: function() {
    return {
      // canvas: null
      code15: "",
      code16: ""
    };
  },
  created: function() {},
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
      this.setCode31();
    },
    setCode31() {
      this.code15 =
        "(" + this.value.slice(0, 2) + ")" + this.value.slice(2, 15);
      this.code16 = this.value.slice(15, 31);
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
