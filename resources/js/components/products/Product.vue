<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Products</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getProducts">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm1>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Products</h3>
                        </v-flex>
                        <v-flex offset-sm8 sm2>
                            <v-btn color="info" @click="openCreate" flat>Create Product </v-btn>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-toolbar tabs color="transparent">
                    <template v-slot:extension>
                        <v-layout row wrap style="height:auto">
                            <VFlex sm12>
                                <v-tabs fixed-tabs style="margin-bottom: 20px;">
                                    <v-tab @click="filter('all')">
                                        All
                                    </v-tab>
                                    <v-tab @click="filter('active')">
                                        Active
                                    </v-tab>
                                    <v-tab @click="filter('inactive')">
                                        Inactive
                                    </v-tab>
                                    <v-tab @click="filter('digital')">
                                        Digital
                                    </v-tab>
                                    <v-tab @click="filter('bundle')">
                                        Bundle
                                    </v-tab>
                                </v-tabs>
                            </VFlex>
                        </v-layout>
                    </template>
                </v-toolbar>
            </v-flex>
            <v-flex sm12>
                <vue-good-table class="table-hover" :columns="columns" :rows="products.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'id', type: 'asc'}}" :select-options="{ enabled: true }" @on-row-dblclick="openEdit" @on-selected-rows-change="selectionChanged" :selectOptions="{ enabled: true, selectOnCheckboxOnly: true}">
                    <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field == 'created_at'">
                            <span>
                                <el-tag type="success">{{props.formattedRow.created_at}}</el-tag>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'lot'">
                            <span>
                                <el-tooltip content="lot" placement="top" v-if="props.row.lot">
                                    <v-avatar style="cursor: pointer" color="green" small></v-avatar>
                                </el-tooltip>
                                <el-tooltip content="Not lot" placement="top" v-else>
                                    <v-avatar style="cursor: pointer" color="red" small></v-avatar>
                                </el-tooltip>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'has_serial'">
                            <span>
                                <el-tooltip content="has serial" placement="top" v-if="props.row.has_serial">
                                    <v-avatar style="cursor: pointer" color="green" small></v-avatar>
                                </el-tooltip>
                                <el-tooltip content="has no serial" placement="top" v-else>
                                    <v-avatar style="cursor: pointer" color="red" small></v-avatar>
                                </el-tooltip>
                            </span>
                        </span>
                        <span v-else-if="props.column.field == 'dangerous'">
                            <span>
                                <el-tooltip content="Dangerous" placement="top" v-if="props.row.dangerous">
                                    <v-avatar style="cursor: pointer" color="green" small></v-avatar>
                                </el-tooltip>
                                <el-tooltip content="Not dangerous" placement="top" v-else>
                                    <v-avatar style="cursor: pointer" color="red" small></v-avatar>
                                </el-tooltip>
                            </span>
                        </span>

                        <span v-else-if="props.column.field == 'featured'">
                            <div class="text-xs-right" v-if="props.row.featured === '1' || props.row.featured === 1">
                                <v-tooltip bottom v-if="user.can['update new products']">
                                    <v-btn icon class="mx-0" @click="StatusItem(props.row, props.row.featured, 'featured', props.row.id)" slot="activator">
                                        <v-icon color="blue darken-2">check_circle</v-icon>
                                    </v-btn>
                                    <span>Make not newP</span>
                                </v-tooltip>
                            </div>
                            <div class="text-xs-right" v-else>
                                <v-tooltip bottom v-if="user.can['update new products']">
                                    <v-btn icon class="mx-0" @click="StatusItem(props.row, props.row.featured, 'featured', props.row.id)" slot="activator">
                                        <v-icon color="danger darken-2">block</v-icon>
                                    </v-btn>
                                    <span>Make newP</span>
                                </v-tooltip>
                            </div>
                        </span>

                        <span v-else-if="props.column.field == 'new_product'">
                            <div class="text-xs-right" v-if="props.row.new_product === '1' || props.row.new_product === 1">
                                <v-tooltip bottom v-if="user.can['update new products']">
                                    <v-btn icon class="mx-0" @click="StatusItem(props.row, props.row.new_product, 'new_product', props.row.id)" slot="activator">
                                        <v-icon color="blue darken-2">check_circle</v-icon>
                                    </v-btn>
                                    <span>Make not newP</span>
                                </v-tooltip>
                            </div>
                            <div class="text-xs-right" v-else>
                                <v-tooltip bottom v-if="user.can['update new products']">
                                    <v-btn icon class="mx-0" @click="StatusItem(props.row, props.row.new_product, 'new_product', props.row.id)" slot="activator">
                                        <v-icon color="danger darken-2">block</v-icon>
                                    </v-btn>
                                    <span>Make newP</span>
                                </v-tooltip>
                            </div>
                        </span>
                        <span v-else-if="props.column.field == 'best_sell'">
                            <div class="text-xs-right" v-if="props.row.best_sell === '1' || props.row.best_sell === 1">
                                <v-tooltip bottom v-if="user.can['update new products']">
                                    <v-btn icon class="mx-0" @click="StatusItem(props.row, props.row.best_sell, 'best_sell', props.row.id)" slot="activator">
                                        <v-icon color="blue darken-2">check_circle</v-icon>
                                    </v-btn>
                                    <span>Make not new product</span>
                                </v-tooltip>
                            </div>
                            <div class="text-xs-right" v-else>
                                <v-tooltip bottom v-if="user.can['update new products']">
                                    <v-btn icon class="mx-0" @click="StatusItem(props.row, props.row.best_sell, 'best_sell', props.row.id)" slot="activator">
                                        <v-icon color="danger darken-2">block</v-icon>
                                    </v-btn>
                                    <span>Make as new product</span>
                                </v-tooltip>
                            </div>
                        </span>
                        <span v-else-if="props.column.field == 'actions'">
                            <v-tooltip bottom v-if="user.can['edit products']">
                                <v-btn slot="activator" icon class="mx-0" @click="openEdit(props.row)">
                                    <v-icon small color="blue darken-2">edit</v-icon>
                                </v-btn>
                                <span>Edit</span>
                            </v-tooltip>
                            <v-tooltip bottom v-if="user.can['delete products']">
                                <v-btn slot="activator" icon class="mx-0" @click="deleteItem(props.row)">
                                    <v-icon small color="pink darken-2">delete</v-icon>
                                </v-btn>
                                <span>Delete</span>
                            </v-tooltip>
                            <v-tooltip bottom v-if="user.can['change products image']">
                                <v-btn slot="activator" icon class="mx-0" @click="imageUpdate(props.row)">
                                    <v-icon small color="info darken-2">image</v-icon>
                                </v-btn>
                                <span>Update image</span>
                            </v-tooltip>
                            <v-tooltip bottom v-if="user.can['view products']">
                                <v-btn slot="activator" icon class="mx-0" @click="view(props.row)">
                                    <v-icon small color="orange darken-2">visibility</v-icon>
                                </v-btn>
                                <span>View Product</span>
                            </v-tooltip>
                        </span>
                        <span v-else>
                            {{props.formattedRow[props.column.field]}}
                        </span>
                    </template>
                </vue-good-table>
            </v-flex>
        </v-layout>
    </v-container>
    <Create></Create>
    <Show></Show>
    <myImage></myImage>
    <!-- <Excel></Excel> -->
</v-content>
</template>

<script>
import Create from './Create';
// import choose from './Choose';
import Show from './Show';
import myImage from "../admin/products/Image";
export default {
    components: {
        myImage,
    },
    props: ['user'],
    components: {
        Create,
        myImage,
        Show,
        // Excel
    },
    data() {
        return {
            form: {},
            loader: false,
            search: '',
            products_det: {
                data: []
            },
            products_search: [],
            temp: '',
            checkedRows: [],

            columns: [{
                    label: 'Id#',
                    field: 'id',
                    type: 'number',
                },
                {
                    label: 'Product Name',
                    field: 'product_name',
                },
                {
                    label: 'Sku Number',
                    field: 'sku_no',
                },
                {
                    label: 'Barcode',
                    field: 'bar_code',
                },
                {
                    label: 'On Hand',
                    field: 'onhand',
                    type: 'number',
                },
                {
                    label: 'Lot Product',
                    field: 'lot',
                    sortable: false,
                },
                {
                    label: 'Has Serial',
                    field: 'has_serial',
                    sortable: false,
                },
                {
                    label: 'Dangerouse Goods',
                    field: 'dangerous',
                    sortable: false,
                },
                {
                    label: "Featured",
                    field: "featured"
                },
                {
                    label: "New Product",
                    field: "new_product"
                },
                {
                    label: "Best Seller",
                    field: "best_sell"
                },
                {
                    label: "Display on Slider",
                    field: "carousel"
                },
                {
                    label: 'Created On',
                    field: 'created_at',
                    type: 'date',
                    dateInputFormat: 'YYYY-MM-DD',
                    dateOutputFormat: 'Do MMMM YYYY',
                },
                {
                    label: 'Actions',
                    field: 'actions',
                    sortable: false,
                },
            ],
        }
    },
    methods: {
        openCreate() {
            eventBus.$emit('openCreateProduct')
        },
        imageUpdate(data) {
            eventBus.$emit("imageEvent", data);
        },
        openExcel() {
            eventBus.$emit('openExcelProduct')
        },
        openUpload() {
            eventBus.$emit('openChooseupload')
        },
        openEdit(data) {
            // console.log(data.row.id)
            // router.push({ name: 'editProducts', params: { id: data.id } })
            this.$router.push({
                name: "editProducts",
                params: {
                    id: data.row.id
                }
            });
            // eventBus.$emit('openEditProduct', data)
        },

        openShow(data) {
            eventBus.$emit('openShowProduct', data)
        },
        getProducts() {
            eventBus.$emit("LoadingEvent");
            this.$store.dispatch('getProducts');

        },
        filter(data) {
            this.$store.dispatch('filterProd_table', data)
        },
        filteredList() {
            // console.log(this.products.data.filter(product => {
            //     return product.product_name.toLowerCase().includes(this.search.toLowerCase())
            // }));
            if (this.search.length < 1) {
                this.products
                return
            } else {
                this.products_det.data = this.products.data.filter(product => {
                    return product.product_name.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        updateSelected(url) {
            // alert('test')
            if (this.checkedRows.length < 1) {
                eventBus.$emit('errorEvent', 'Please select atleast one row')
                return
            }

            this.$store.dispatch('updateSelected', {
                    url,
                    checked: this.checkedRows
                })
                .then((response) => {
                    eventBus.$emit('alertRequest', 'Updated')
                    this.checkedRows = []
                    this.getProducts()
                })
        },
        selectionChanged(params) {
            this.checkedRows = params.selectedRows
        },
        deleteItem(item) {
            if (confirm("Are you sure you want to delete this item?")) {
                this.loading = true;
                axios
                    .delete(`/products/${item.id}`)
                    .then(response => {
                        this.loading = false;
                        this.message = "deleted successifully";
                        this.color = "black";
                        this.snackbar = true;
                        this.products.splice(index, 1);
                    })
                    .catch(error => {
                        this.loading = false;
                        this.message = "something went wrong";
                        this.color = "red";
                        this.snackbar = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },

        view(product) {
            eventBus.$emit("viewProEvent", product);
        },
        StatusItem(item, data, status, id) {
            this.loading = true;
            // this.editedIndex = this.products.indexOf(item)
            // this.editedItem = Object.assign({}, item)
            axios
                .post(`/StatusItem/${id}`, {
                    data: data,
                    status: status
                })
                .then(response => {
                    this.getProducts();
                    eventBus.$emit('alertRequest', 'updated')
                    // Object.assign(this.products[this.editedIndex], this.response.data)
                    // Object.assign(this.products[this.editedIndex], data)
                    // this.products = response.data;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
    },
    computed: {
        products() {
            return this.$store.getters.products
            // }

        },
        products_filter() {
            return this.$store.getters.products
        },

        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        // this.$store.dispatch('getProducts');
        eventBus.$emit("LoadingEvent");
        this.getProducts();
    },
    created() {
        eventBus.$on('productEvent', data => {
            this.getProducts();
        })

        eventBus.$on('responseChooseEvent', data => {
            console.log(data);
            if (data == 'Excel') {
                eventBus.$emit('openExcelProduct')
            } else {
                eventBus.$emit('openCreateProduct')
            }
        })
    },
}
</script>

<style scoped>
.el-input--prefix .el-input__inner {
    border-radius: 50px !important;
}

.v-toolbar__content,
.v-toolbar__extension {
    height: auto !important;
}

.v-avatar {
    height: 10px !important;
    width: 10px !important;
    margin-left: 40% !important;
}
</style>
