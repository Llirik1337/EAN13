<template>
  <div :key="Math.random()">
        {{this.codeean}}
      <table width="500">
          <tr>
          <td width="35%">
              {{ this.tovarName }}
          </td>
          <td width="65%"><canvas ref="barcode" style="width: 35mm; height: 35mm"></canvas></td>
        </tr>
        <tr>

          <td width="35%"></td>
          <td width="65%">{{ this.code15 }}</td>
        </tr>
        <tr>
          <td width="35%"></td>
          <td width="65%">{{ this.code16 }}</td>
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
          default: ''
      },
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
      code15: "",
      code16: ""
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

    async init() {
      if (this.value == null || this.tovarName == null) return;
      this.generateBarcode(this.value)
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
                text: value,
            });
        } catch (e) {
            console.log(e);
        }
    },
  }
};
</script>

<style></style>
