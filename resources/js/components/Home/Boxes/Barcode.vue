<template>
  <div ref="barcode">
    <canvas id="barcode"></canvas>
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
    return {};
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
        bcid: "ean13",
        text: value,
        // scale: 3,
        height: 18,
        width: 50,
        includetext: true,
        textxalign: "center"
      });
    }
  }
};
</script>

<style></style>
