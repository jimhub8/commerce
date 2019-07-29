<template>
<div style="padding: 20px 0;">
    <h2 class="text-center">Customs Information</h2>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex xs12 sm6>
            <v-flex xs12 sm8 offset-sm2>
                <label for="" style="color: #52627d;">Tariff Code</label>
                <el-input placeholder="Tariff Code" v-model="product.tariff_code"></el-input>
            </v-flex>
            <v-flex xs12 sm8 offset-sm2>
                <label for="" style="color: #52627d;">Value</label>
                <el-input placeholder="Value" v-model="product.value"></el-input>
            </v-flex>
            <v-flex xs12 sm8 offset-sm2>
                    <label for="" style="color: #52627d;">Description</label>
                <el-input type="textarea" :autosize="{ minRows: 2, maxRows: 4}" placeholder="Description" v-model="product.description" maxlength="500" show-word-limit>
                </el-input>
            </v-flex>
        </v-flex>
        <v-flex xs12 sm3 offset-sm2>
            <v-card :color="color">
                <v-card-title>
                    Heads up!
                </v-card-title>
                <v-card-text>
                    <p>Checking off all that apply will ensure we fulfill your products accurately.</p>
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
