<template>
  <div ref="barcode" id="print">
    <table>
      <tr valign="top">
        <td width="150px">{{this.tovarName}}</td>
        <td align="center" width="150px">
          <canvas id="barcode" style="width: 100px; height: 100px"></canvas>
        </td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td style="font-size:8pt;" width="150px">{{value.slice(0,30)}}</td>
      </tr>
    </table>
  </div>
</template>

<script>
import bwipjs from "bwip-js";
import printJS from 'print-js'

import { mapActions, mapGetters } from "vuex";
export default {
  props: ["value", "tovarName", "toPrint"],
  data: function() {
    return {
      canvas: null
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
      // this.canvas = document.createElement('canvas');
      // this.canvas.id = "barcode";
      // this.canvas.width = 200;
      // this.canvas.height = 200;

      // console.log("barcode is updated");
      this.generateBarcode(this.value);
      this.printBarcode();
    },

    printBarcode() {


      printJS({
        printable: 'print',
        type: 'html',
        style: '@page { size: 50:47 landscape; }'
      });
      // const windowPrint = window.open(
      //   "",
      //   "",
      //   `left=50,top=50,width=800,height=600,toolbar=0,scrollbars=1,status=0`
      // );
      // let windowContent = `<!DOCTYPE html>
      // <html>
      // <head>
      // <title>
      //   Print DM code
      // </title>
      // </head>
      // <style>

      // @media (orientation: landscape) {
      //   body {
      //     flex-direction: row;
      //   }
      // }

      // </style>
      // <body>

      //   <div>
      //     <table>
      //       <tr valign="top">
      //         <td width="150px">${this.tovarName}</td>
      //         <td align="center" width="150px">
      //           <img width="100px;" height="100px" src="${this.canvas.toDataURL()}">
      //         </td>
      //       </tr>
      //       <tr>
      //         <td width="150px">
      //         </td>
      //         <td style="font-size:8pt;" width="150px">
      //           ${this.value.slice(0, 30)}
      //         </td>
      //       </tr>
      //     </table>
      //   </div>
      // </body>
      // </html>`;
      // windowPrint.document.write(windowContent);
      // windowPrint.document.close();
      // windowPrint.focus();
      // setTimeout(() => {
      //   windowPrint.print();
      // }, 500);

      // if (this.toPrint) windowPrint.close();
    },

    generateBarcode(value) {
      this.canvas = bwipjs.toCanvas("barcode", {
        bcid: "gs1datamatrix",
        // text: '010290000005567421)0s/ZWOgw*rR291803992+a1NMJUigZLn90FzCjxqROBsUIK9Wl8SxGKQgCvPPI9ElQ0y0CHtNs//L23Nrv3vS6fFLq7XLDgJQUaUMaklMg==',
        // text: '\x1D01)0290000050693021ykkmFLVfyYsD&91002A92LPUFmj71fy38Fv4utf49Yz+tP8qSGFKuxxC8mBDwazx0wHaEdB5Yw0qaMldIERdS5/BctoGshmy9LwumSaz4ZQ==',
        // text: '\x1D01)0290000050693021zWyihTWia/Tkl91002A92BGfgHgkPKfzgj4hiBwGPlC2X6u9jaDyqx50q7oBEaU5BxLV/iD5gKoO+VgRQcLv2LWjk0LGp3eK1RA+6Mx9H9A=='
        // text: '\x1D01)0290000050693021Zsi2hiqc%mH"C91802992BGKKmM1Huh2oNPX+/vbgyJGWAKfcjouMNZc+mIhWd/n6uWkr4EYLJQXcoPjYf3Di/2VLM7qrqGn4MJiqnhlpjw=='
        text: this.modValue(value),
        // "\x1D01)0290000050693021ZRXQ9n_pRt!e?91002A92GDMq2uaHMa1Pb5yDRdybTThLTf5WAx/61Mxn118bUVlyr3r8z87BBdpwlobIahC6xwGcyWwwfK1ykyGX4RtY5g==",
        scale: 3,
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

<style>
</style>