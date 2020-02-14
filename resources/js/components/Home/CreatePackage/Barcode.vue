<template>
  <div ref="barcode">
    <div style="font-size:8pt;">
      <table width="400px">
        <tr>
          <td width="65%">
            <canvas id="barcode" style="width: 40mm; height: 40mm"></canvas>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import bwipjs from "bwip-js";

import { mapActions, mapGetters } from "vuex";
export default {
  props: {
    value: {
      required: true,
      type: String
    }
  },
  data: function() {
    return {
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
    init() {
      this.generateBarcode(this.value);
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
