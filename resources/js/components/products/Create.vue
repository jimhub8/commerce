<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <!-- <el-dialog title="Sku Prefix" :visible.sync="dialog" width="30%">
            <el-input v-model="form.prefix" autocomplete="off"></el-input>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialog = false">Cancel</el-button>
                <el-button type="primary" @click="update">Submit</el-button>
            </span>
        </el-dialog> -->
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Product</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm12>
                            <v-text-field label="Product name*" required v-model="form.product_name"></v-text-field>
                            <small class="has-text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                        </v-flex>
                        <v-flex xs10 sm10>
                            <v-text-field label="Sku Number" v-model="form.sku_no" :disabled="disabled"></v-text-field>
                            <small class="has-text-danger" v-if="errors.sku_no">{{ errors.sku_no[0] }}</small>
                        </v-flex>
                        <v-flex sm2>
                            <v-tooltip bottom v-if="disabled">
                                <v-btn icon class="mx-0" @click="sku_input" slot="activator">
                                    <v-icon small color="primary darken-2">settings</v-icon>
                                </v-btn>
                                <span>Input sku</span>
                            </v-tooltip>
                            <v-tooltip bottom v-else>
                                <v-btn icon class="mx-0" @click="sku_generate" slot="activator">
                                    <v-icon small color="primary darken-2">settings</v-icon>
                                </v-btn>
                                <span>Generate sku</span>
                            </v-tooltip>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="save" :loading="loading" :disabled="loading">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- <addClient></addClient> -->
</v-layout>
</template>

<script>
// import addClient from '../select/client/Create'
export default {
    components: {
        // addClient,
    },
    data: () => ({
        dialog: false,
        disabled: true,
        selected: [],
        loading: false,
        form: {
            product_name: '',
            sku_no: '',
            client_id: '',
        },
        data: [],
        errors: {},
    }),
    created() {
        eventBus.$on('openCreateProduct', data => {
            this.dialog = true
            this.uniquesku_no()
        })
    },

    methods: {
        save() {
            this.errors = {}
            this.loading = true
            axios.post('/products', this.$data.form).then((response) => {
                this.loading = false
                // console.log(response);
                this.$store.dispatch('alertEvent', 'Product added')
                this.$store.dispatch('getProducts')
                eventBus.$emit('productEvent', data)
                this.close()
            }).catch((error) => {
                // console.log(error.response);
                this.loading = false
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    this.loading = false
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                }
                this.errors = error.response.data.errors
            })
        },

        getAsyncData(name) {
            this.loading = true
            if (name.length < 3) {
                this.data = []
                this.loading = false
                return
            }
            this.form.search = name
            axios.get(`searchClient/${name}`).then((response) => {
                this.loading = false
                this.data = response.data
            }).catch((error) => {
                this.loading = false
            })
        },
        close() {
            this.dialog = false
        },
        uniquesku_no() {
            axios.get('/uniquesku_no', this.$data.form).then((response) => {
                this.loading = false
                // console.log(response);
                this.form.sku_no = response.data
            }).catch((error) => {
                // console.log(error.response);
                this.loading = false

            })
        },
        addClient() {
            eventBus.$emit('openCreateBox')
        },

        select_client(data) {
            // alert('test')
            // console.log(data);
            this.form.client_id = data.id

        },
        sku_input() {
            this.disabled = false
        },
        sku_generate() {
            this.disabled = true
            this.uniquesku_no()
        }
    },
    mounted() {
        // this.uniquesku_no()
    },
}
</script>
