<template>
    <a-modal v-model="visible" title="Printed">
        <barcodes :codeean="codeean" :afterRender="afterRender" :codes="codes" :tovarName="tovarName"></barcodes>
        <a-button @click="afterRender()">Print</a-button>
    </a-modal>
</template>

<script>
    import Barcodes from "./Barcodes";
    export default {
        components: {Barcodes},
        props:{
            visible: Boolean,
            codeean: {
                type: String,
                default: ''
            },
            afterRender: {
                type: Function,
            },
            codes: {
                type: Array,
                required: true
            },
            tovarName: {
                type:String,
                required: true
            }
        },
        name: "modalBarcodes",
    }
</script>

<style scoped>

</style>
