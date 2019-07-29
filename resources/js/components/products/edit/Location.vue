<template>
<el-table :data="product_warehouse" style="width: 100%" :row-class-name="tableRowClassName">
    <el-table-column prop="warehouse_name" label="LOCATION" width="180"></el-table-column>
    <el-table-column prop="onhand" label="ON HAND" width="180"></el-table-column>
    <el-table-column prop="commited" label="COMMITED"></el-table-column>
    <el-table-column prop="reorder_point" label="REORDER POINT NOTIFICATION"></el-table-column>
</el-table>
</template>

<style>
.el-table .warning-row {
    background: oldlace;
}

.el-table .success-row {
    background: #f0f9eb;
}
</style>

<script>
export default {
    props: ['product'],
    data() {
        return {
            tableData: []
        }
    },
    methods: {
        tableRowClassName({
            row,
            rowIndex
        }) {
            if (rowIndex === 1) {
                return 'warning-row';
            } else if (rowIndex === 3) {
                return 'success-row';
            }
            return '';
        },

    },
    computed: {
        product_warehouse() {
            return this.$store.getters.product_warehouse
        }
    },
    created() {
        eventBus.$on("openEditProduct", data => {
            // console.log(data);
        });
    },
}
</script>
