<template>
    <div>
        <barcode
            v-for="item in codes"
            :key="Math.random()"
            :value="item.code"
            :tovar-name="tovarName"
            :codeean="codeean"
        />
    </div>
</template>

<script>
import Barcode from "../Search/Barcode";
export default {
    components: {
        Barcode
    },
    props: {
        codeean: {
            type: String,
            default: ""
        },
        codes: {
            type: Array,
            required: true
        },
        tovarName: {
            type: String,
            required: true
        }
    },
    mounted() {
        this.$nextTick(function() {
            // this.afterRender();
            setTimeout(() => this.$emit("render"), 1000);
        });
    }
};
</script>

<style scoped>
@media print {
    .new-page {
        page-break-after: always;
    }
}
</style>
