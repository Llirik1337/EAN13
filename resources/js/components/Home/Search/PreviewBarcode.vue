<template>
    <a-modal title="Preview barcode" :visible="true" @cancel="cancel">
        <barcode :value="value" :tovarName="tovarName" :preview="true"></barcode>
    </a-modal>
</template>

<script>
import Barcode from "./Barcode";
export default {
  props: ["value", "tovarName"],
  inject: ['hidePreviewBarcode'],
  components: {
      Barcode
  },
  mounted() {
console.log('test');

  },
  methods: {
      cancel(e) {
          this.hidePreviewBarcode();
      }
  }
}
</script>

<style>

</style>
