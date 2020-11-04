<template>
    <span>
        <a-checkbox v-model="printAll">All</a-checkbox>
        <a-input-number :min="1" :disabled="printAll" v-model="count" />
        <a-button @click.stop="print()">
            Print
        </a-button>
    </span>
</template>

<script>
export default {
    name: "PrintAction",
    data: () => ({ count: 1, printAll: true }),
    methods: {
        print() {
            this.$emit("print", this.printAll ? false : this.count);
        }
    }
};
</script>

<style scoped></style>
