<template>
    <component :is="template" :data="data"></component>
</template>

<script>

export default {
    name: "BarcodePrintField",
    props: [
      "template",
        "data"
    ],
    mounted() {
        console.log('data -> ',this.data);
        console.log('template -> ',this.template)
    }
}
</script>

<style scoped>

</style>
