<template>
    <a-select v-model:value="template" style="width: 120px">
        <a-select-option v-for="(templateListItem, index) in templatesListTitle" :key="index">
            <slot v-bind:templateItem="templateListItem">
                {{ templateListItem }}
            </slot>
        </a-select-option>
    </a-select>
</template>

<script>

export default {
    name: "SelectBarcodeTemplate",
    props: {
        templatesListTitle: {
            type: Array,
            default: []
        }
    },
    data: () => ({
        template: 0,
    }),
    mounted() {
    },
    watch: {
        template() {
            this.$emit('change', this.template);
        }
    }
}
</script>

<style scoped>

</style>
