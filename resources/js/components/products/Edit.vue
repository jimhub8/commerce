<template>
<div>
    <v-content>
        <v-container fluid fill-height>
            <v-layout justify-center align-center>
                <v-layout wrap>
                    <v-flex sm12>
                        <VCard style="padding: 30px;">
                        <el-breadcrumb separator-class="el-icon-arrow-right">
                            <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                            <el-breadcrumb-item :to="{ path: '/products' }">Products</el-breadcrumb-item>
                        <el-breadcrumb-item>{{ product.product_name }}</el-breadcrumb-item>
                        </el-breadcrumb>
                        </VCard>
                    </v-flex>
                    <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <v-container fill-height>
                                    <v-layout align-center>
                                        <v-flex>
                                            <div data-v-1bd51565="" data-v-5b54b316="" style="display: flex; flex-wrap: wrap;">
                                                <div data-v-1bd51565="" class="image-flex-wrapper">
                                                    <div data-v-1bd51565="" class="image-wrapper">
                                                        <img :src="avatar" v-if="avatar" style="width: 130px;height: 125px;">
                                                        <div data-v-1bd51565="" class="icon-image" v-else></div>
                                                        <!---->
                                                    </div>
                                                </div>
                                                <div data-v-1bd51565="" class="details-flex-wrapper">
                                                    <div data-v-1bd51565="" class="details-wrapper">
                                                        <div data-v-1bd51565="" class="title">
                                                            <h3 data-v-1bd51565="">{{ product.product_name }}</h3>
                                                        </div>
                                                        <p data-v-1bd51565="">On-hand:
                                                            <b data-v-1bd51565="">{{ product.onhand }}</b>
                                                        </p>
                                                        <p data-v-1bd51565="" v-if="product.active">Status: <b data-v-1bd51565="">Active</b></p>
                                                        <p data-v-1bd51565="" v-else>Status: <b data-v-1bd51565="">Inactive</b></p>
                                                        <div data-v-861aa9f6="" data-v-1bd51565="" class="file-upload-link">
                                                            <label data-v-861aa9f6="" for="imageUpload">
                                                                <span data-v-861aa9f6="" class="btn-link underline pointer">Upload Image </span>
                                                            </label>
                                                            <input data-v-861aa9f6="" id="imageUpload" type="file" style="display: none;" @change="Getimage">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-hover>
                    </v-flex>
                    <div style="height: 250px;"></div>
                    <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <v-container fill-height>
                                    <Basicinfo :product="product"></Basicinfo>
                                </v-container>
                            </v-card>
                        </v-hover>
                    </v-flex>
                    <div style="height: 570px;"></div>
                    <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <Status :product="product"></Status>
                            </v-card>
                        </v-hover>
                    </v-flex>
                    <div style="height: 210px;"></div>
                    <!-- <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <Fulfillment :product="product"></Fulfillment>
                            </v-card>
                        </v-hover>
                    </v-flex> -->
                    <!-- <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <Customer :product="product"></Customer>
                            </v-card>
                        </v-hover>
                    </v-flex> -->
                    <!-- <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <Package :product="product" :boxes="boxes" :classifications="classifications"></Package>
                            </v-card>
                        </v-hover>
                    </v-flex> -->
                    <!-- <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%" style="padding: 20px;">
                                <Variant :form="form" :product="product"></Variant>
                            </v-card>
                        </v-hover>
                    </v-flex> -->
                    <div style="height: 240px;"></div>
                    <!-- <v-flex sm12>
                        <v-hover>
                            <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="100%">
                                <Location :product="product"></Location>
                            </v-card>
                        </v-hover>
                    </v-flex> -->
                    <v-btn flat color="primary" :loading="loading" :disabled="loading" style="border: 1px solid; border-radius: 20px;" @click="update">Save</v-btn>
                </v-layout>
            </v-layout>
        </v-container>
    </v-content>
</div>
</template>

<script>
import Status from './edit/Status'
// import Customer from './edit/Customer'
// import Fulfillment from './edit/Fulfillment'
// import Package from "./edit/Package";
// import Location from "./edit/Location";
import Basicinfo from "./edit/Basicinfo";
// import Variant from './edit/Variant';
import {
    Updateproduct
} from '../../helpers/Product'
export default {
    components: {
        Status,
        // Fulfillment,
        // Customer,
        // Package,
        // Location,
        Basicinfo,
        // Variant
    },
    data: () => ({
        loading: false,
        dialog: false,
        product: [],
        form: {
            has_varients: false,
            variants_d: [{
                variants: {},
                subvariants: {},
                model: []
            }]
        },
        avatar: '',
    }),
    computed: {
        products() {
            return this.$store.getters.products;
        },

        boxes() {
            return this.$store.getters.boxes
        },
        types() {
            return this.$store.getters.types;
        },
        classifications() {
            return this.$store.getters.classifications;
        }
    },
    methods: {
        update() {
            this.loading = true
            // if (this.product.has_varients) {
            //     this.product.push(this.form)
            // }
            axios.patch(`/products/${this.product.id}`, {
                product: this.$data.product,
                form: this.$data.form,
            }).then((response) => {
                this.loading = false
                // console.log(response);
                this.$store.dispatch('alertEvent', 'Product updated')
                // alert('success')
                // context.commit('getProducts', response.data)
                // eventBus.$emit('productEvent', data)
            }).catch((error) => {
                alert('error')
                // console.log(error.response);
                this.loading = false

            })
        },
        Getimage(e) {
            let image = e.target.files[0];
            // this.read(image);
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                this.avatar = e.target.result;
            };
            this.imagePlaced = true;
            let form = new FormData();
            form.append("image", image);
            this.file = form;
            // console.log(e.target.files);
            this.upload()
        },

        upload() {
            // this.loading = true;
            axios
                .post(`/pro_image/${this.product.id}`, this.file)
                .then(response => {
                    // this.loading = false;
                    this.$store.dispatch('alertEvent', 'Image uploaded')
                    console.log(response);
                    this.imagePlaced = false;
                })
                .catch(error => {
                    // this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit("errorEvent", error.response.statusText);
                        return;
                    }
                    this.errors = error.response.data.errors;
                    this.errors = error.response.data.errors;
                });
        },
        // close() {
        //     this.dialog = false
        // },
        getProduct(id) {
            if (this.products.length > 0) {
                this.product = this.products.find(
                    product => product.id == this.$route.params.id
                );
                this.avatar = this.product.image
            } else {
                axios
                    .get(`/products/${id}`)
                    .then(response => {
                        this.loading = false;
                        this.product = response.data;
                        // console.log(response);
                        this.avatar = response.data.image
                        // this.close()
                        // context.commit('getProducts', response.data)
                    })
                    .catch(error => {
                        // console.log(error.response);
                        this.loading = false;
                    });
            }
        },
        getTypes() {
            this.$store.dispatch("getTypes");
        },
        getBoxes() {
            this.$store.dispatch('getBoxes');
        },
        getClassifications() {
            this.$store.dispatch("getClassifications");
        },
        getCategory(id) {
            this.$store.dispatch('getCategory', id)
        },
        product_warehouse(id) {
            this.$store.dispatch('product_warehouse', id)
        },
    },
    created() {
        eventBus.$on("openEditProduct", data => {
            this.dialog = true;
            this.form = data;
            // this.product_warehouse()
            // console.log(data);
        });
    },
    mounted() {
        this.getProduct(this.$route.params.id);
        this.getCategory()
        this.getTypes()
        this.getBoxes()
        this.getClassifications()
        this.product_warehouse(this.$route.params.id)
    },

};
</script>

<style scoped>
.icon-image[data-v-1bd51565]:before {
    content: "\E920";
    font-size: 100px;
}

.image-flex-wrapper[data-v-1bd51565] {
    position: relative;
    margin-right: 1em;
    text-align: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
}

.image-flex-wrapper .image-wrapper[data-v-1bd51565] {
    padding: 0.5em;
    border-radius: 6px;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
    border: none;
    height: 10em;
    width: 10em;
}

.icon-image[data-v-1bd51565] {
    background-color: #f9fafb;
    font-size: 5em;
    color: rgba(0, 0, 0, 0.21);
    height: 100%;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-radius: 6px;
}

[class^="icon-"],
[class*=" icon-"] {
    font-family: "Speedball-App" !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

[class^="icon-"],
[class*=" icon-"] {
    font-family: "icomoon" !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

[class*=" icon-"],
[class^="icon-"] {
    font-family: icomoon !important;
    speak: none;
    font-style: normal;
    font-weight: 400;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>
