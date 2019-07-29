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
                        <v-flex sm2>
                            <!-- <el-input placeholder="Search all inventory..." v-model="search" @input="FilterProducts">
                                <i slot="prefix" class="el-input__icon el-icon-search"></i>
                            </el-input> -->
                            <!-- <input type="text" class="form-control" v-model="search" @input="customFilter(products.data, search)"> -->
                        </v-flex>
                        <v-flex sm1 style="margin-top: -4px">
                            <v-btn flat color="primary">Reset filter</v-btn>
                        </v-flex>
                        <v-flex sm1 offset-sm2>
                            <el-dropdown>
                                <el-button type="primary">
                                    Actions<i class="el-icon-arrow-down el-icon--right"></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item>
                                        <div @click="updateSelected('activate')">Activate Product</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('deactivate')">Deactivate Product</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('digital')">Mark as Digital</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('notdigital')">Mark as Not Digital</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('merge')">Merge Products</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('dangerous')">Mark as Dangerous</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('notdangerous')">Mark as Not Dangerous</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('lot')">Mark as Lot</div>
                                    </el-dropdown-item>
                                    <el-dropdown-item>
                                        <div @click="updateSelected('notlot')">Mark as Not Lot</div>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </v-flex>
                        <v-flex sm5>
                            <el-button-group>
                                <el-button type="primary" @click="openUpload">Add product</el-button>
                                <el-button type="primary">Edit Column</el-button>
                                <el-dropdown>
                                    <el-button type="primary">
                                        More<i class="el-icon-arrow-down el-icon--right"></i>
                                    </el-button>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item>Product History</el-dropdown-item>
                                        <el-dropdown-item>Inventory Status</el-dropdown-item>
                                        <el-dropdown-item>Download inventory Form</el-dropdown-item>
                                        <el-dropdown-item>Download Complete Inventory</el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </el-button-group>
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
                <section style="overflow: scroll;">
                    <b-table :data="isEmpty ? [] : products.data" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading" :focusable="isFocusable" :mobile-cards="hasMobileCards" checkable :paginated="isPaginated" :per-page="perPage" :current-page.sync="currentPage" default-sort="id" default-sort-direction="desc" :checked-rows.sync="checkedRows">
                        <template slot-scope="props">
                            <b-table-column sortable field="id" label="ID" width="40" numeric style="cursor: pointer">
                                <a @click="openEdit(props.row)">{{ props.row.id }}</a>
                            </b-table-column>
                            <b-table-column sortable field="product_name" label="NAME" width="40">
                                {{ props.row.product_name }}
                            </b-table-column>
                            <b-table-column sortable field="sku_no" label="SKU">
                                {{ props.row.sku_no }}
                            </b-table-column>

                            <b-table-column sortable field="onhand" label="ON HAND">
                                {{ props.row.onhand }}
                            </b-table-column>
                            <b-table-column sortable field="platform" label="PLATFORM">
                                {{ props.row.platform }}
                            </b-table-column>
                            <b-table-column sortable field="bar_code" label="BARCODE">
                                {{ props.row.bar_code }}
                            </b-table-column>
                            <b-table-column sortable field="lot_product" label="LOT PRODUCT">
                                {{ props.row.lot }}
                            </b-table-column>
                            <b-table-column sortable field="has_serial" label="HAS SERIAL">
                                {{ props.row.has_serial }}
                            </b-table-column>
                            <b-table-column sortable field="dangerous" label="DANGEROUS GOODS">
                                {{ props.row.dangerous }}
                            </b-table-column>
                            <b-table-column sortable field="created_at" label="CREATED ON" centered>
                                <span class="tag is-info">
                                    {{ props.row.created_at }}
                                    <!-- {{ props.row.created_at }} -->
                                </span>
                            </b-table-column>
                        </template>

                        <template slot="empty">
                            <section class="section">
                                <div class="content has-text-grey has-text-centered">
                                    <p>
                                        <b-icon icon="emoticon-sad" size="is-large">
                                        </b-icon>
                                    </p>
                                    <p>Nothing here.</p>
                                </div>
                            </section>
                        </template>
                    </b-table>
                </section>
            </v-flex>
        </v-layout>
    </v-container>
    <Create></Create>
    <Show></Show>
    <choose></choose>
    <Excel></Excel>
</v-content>
</template>

<script>
import Create from './Create';
import choose from './Choose';
import Show from './Show';
import Excel from './Excel';
export default {
    components: {
        Create, choose, Show, Excel
    },
    data() {
        return {
            form: {},
            loader: false,
            isEmpty: false,
            isBordered: true,
            isStriped: true,
            isNarrowed: false,
            isHoverable: true,
            isFocusable: true,
            hasMobileCards: true,
            isPaginated: true,
            currentPage: 1,
            perPage: 5,
            search: '',
            products_det: {
                data: []
            },
            products_search: [],
            temp: '',
            checkedRows: [],
        }
    },
    methods: {
        openCreate() {
            eventBus.$emit('openCreateProduct')
        },
        openExcel() {
            eventBus.$emit('openExcelProduct')
        },
        openUpload() {
            eventBus.$emit('openChooseupload')
        },
        openEdit(data) {
            // router.push({ name: 'editProducts', params: { id: data.id } })
            this.$router.push({
                name: "editProducts",
                params: {
                    id: data.id
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
        }
    },
    computed: {
        products() {
            // if (this.search.length > 0) {
            //     // alert('test')
            //     return this.$store.getters.products.data.filter(product => {
            //         var data = []
            //         data.push(product.product_name.toLowerCase().includes(this.search.toLowerCase()))
            //         console.log(data);
            //         return data
            //     })
            // } else {
            // return this.products_det = this.$store.getters.products
            return this.$store.getters.products
            // }

        },
        products_filter() {
            return this.$store.getters.products
        },
        all_products() {
            return this.$store.getters.products
        },
        // filteredList() {
        //     return this.products.data.filter(product => {
        //         return this.products_det =  product.product_name.toLowerCase().includes(this.search.toLowerCase())
        //     })
        // },

        isLoading() {
            return this.$store.getters.loading;
        },

        FilterProducts(items, search, filter) {
            //this custom filter will do a multi-match separated by a space.
            //e.g

            if (!search) {
                return items
            } //if the search is empty just return all the items

            function new_filter(val, search) {
                return val !== null && ['undefined', 'boolean'].indexOf(typeof val) === -1 &&
                    val.toString().toLowerCase().replace(/[^0-9a-zA-Z]+/g, "").indexOf(search) !== -1
            }

            let needleAry = search.toString().toLowerCase().split(" ").filter(x => x);
            //whenever we encounter a space in our search we will filter for both the first and second word (or third word)

            return items.filter(row => needleAry.every(needle => Object.keys(row).some(key => new_filter(row[key], needle))));
            //foreach needle in our array cycle through the data (row[key]) in the current row looking for a match.
            // .some will return true and exit the loop if it finds one it will return false if it doesnt
            // .every will exit the loop if we dont find a match but will return true if all needles match
            // .filter the rows on each match

        }

    },
    watch: {
        // search() {
        //     if (this.search.length > 0) {
        //         return this.products.data.filter((item) => {
        //             return item.product_name.toLowerCase().indexOf(this.search.toLowerCase()) > -1
        //         });
        //     } else {
        //         // alert('test')
        //         return this.products.data = this.all_products.data
        //     }
        // }
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
</style>
