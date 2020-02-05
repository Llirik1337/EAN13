<template>
  <div ref="barcode" id="print">
    <div  style="width:57mm">
    <a-row type="flex" >
      <a-col :span="6">{{this.tovarName}}</a-col>
      <a-col><canvas id="barcode" style="width: 100px; height: 100px"></canvas></a-col>
    </a-row>
    <a-row type="flex">
      <a-col :offset="6">{{this.code15}}</a-col>
    </a-row>
      <a-row type="flex">
      <a-col :offset="6">{{this.code16}}</a-col>
    </a-row>
    </div>
    <!-- <table>
      <tr valign="top">
        <td width="150px">{{this.tovarName}}</td>
        <td align="center" width="150px">
          
        </td>
      </tr>
      <tr>
        <td width="150px"></td>
        <td style="font-size:8pt;" width="150px">{{this.code15}}<br>{{this.code16}}</td>
      </tr>
    </table> -->
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
      // canvas: null
      code15: '',
      code16: ''
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
      if(this.value == null || this.tovarName == null) 
        return;
      this.generateBarcode(this.value);
      this.printBarcode();
      this.setCode31();
    },
    setCode31() {
      this.code15 = '(' +this.value.slice(0,2) + ')' + this.value.slice(2,15);
      this.code16 = this.value.slice(15,31);
    },

    printBarcode() {


      printJS({
        printable: 'print',
        type: 'html',
        style: `@page {
           size: Letter landscape;
           size: 57mm 40mm;
           margin: 0px; 
          }`
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
      bwipjs.toCanvas("barcode", {
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