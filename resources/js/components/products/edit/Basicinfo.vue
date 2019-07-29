<template>
<div>
    <h1 class="text-center"><strong>Basic Product Information</strong></h1>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex xs12 sm6>
            <v-layout wrap>
                <v-flex xs12 sm12 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Product name*</label>
                    <el-input placeholder="Product name*" v-model="product.product_name"></el-input>
                </v-flex>
                <v-flex xs12 sm3 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">MFT ID</label>
                    <el-input placeholder="MFT ID" disabled v-model="product.id"></el-input>
                </v-flex>
                <v-flex xs12 sm3 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Platform Source</label>
                    <el-input placeholder="Platform Source" disabled v-model="product.platform"></el-input>
                </v-flex>
                <v-flex xs12 sm3 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">SKU</label>
                    <el-input placeholder="SKU" disabled  min="0" v-model="product.sku_no"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Barcode</label>
                    <el-input placeholder="Barcode" v-model="product.bar_code"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Re-Order Point</label>
                    <el-input placeholder="Re-Order Point" min="0" type="number" v-model="product.reorder_point"></el-input>
                </v-flex>
                <v-flex xs4 sm3 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Length(in)</label>
                    <el-input placeholder="Length(in)" min="0" type="number" v-model="product.length"></el-input>
                </v-flex>
                <v-flex xs4 sm3 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Width(in)</label>
                    <el-input placeholder="Width(in)" min="0" type="number" v-model="product.width"></el-input>
                </v-flex>
                <v-flex xs4 sm3 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Height(in)</label>
                    <el-input placeholder="Height(in)" min="0" type="number" v-model="product.height"></el-input>
                </v-flex>
                <v-flex xs12 sm5  offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Weight(KGs)</label>
                    <el-input placeholder="Weight(KGs)" min="0" type="number" v-model="product.weight"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Qty Available</label>
                    <el-input placeholder="available" min="0" type="number" v-model="product.qty"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">Price</label>
                    <el-input placeholder="List Price" min="0" type="number" v-model="product.price"></el-input>
                </v-flex>
                <v-flex xs12 sm5 offset-sm1 style="padding: 7px 0;">
                    <label for="" style="color: #52627d;">List Price</label>
                    <el-input placeholder="List Price" min="0" type="number" v-model="product.list_price"></el-input>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex xs12 sm3 offset-sm3>
            <v-card :color="color">
                <v-card-title>
                    Heads up!
                </v-card-title>
                <v-card-text>
                    <p>Tell us about your product. The unique barcode will help us scan and identify the product.</p>
                    <br>
                    <p>Once you set the re-order point, we will notify you when the on-hand level matches the re-order point, so you can send us more inventory!</p>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    props: ['product'],
    data() {
        return {
            color: '#f4f6f8',
        }
    },
}
</script>
