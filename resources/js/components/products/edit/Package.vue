<template>
<div style="padding: 20px 0;">
    <h3 class="text-center">Box Type</h3>
    <v-divider></v-divider>
    <v-layout row wrap>
        <v-flex sm5 offset-sm1>
            <el-select v-model="product.box_id" filterable placeholder="Select" clearable>
                <el-option v-for="item in boxes" :key="item.id" :label="item.name" :value="item.id">
                </el-option>
            </el-select>
            <v-container fluid>
                <v-layout wrap>
                    <v-flex sm12 v-for="classification in classifications" :key="classification.id">
                        <v-checkbox v-model="product.classification_id" :value="classification.id" :label="classification.name"></v-checkbox>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>

        <v-flex xs12 sm3 offset-sm2>
            <v-card :color="color">
                <v-card-title>
                    Heads up!
                </v-card-title>
                <v-card-text>
                    <small>Based on your selection for box type, we adjust our packing process.</small>
                    <br>
                    <small>We add necessary packing material for fragile products.</small>
                    <br>
                    <small>Please note this is a guide, not a guarantee. Final box type will depend on the discretion of our fulfillment associates.</small>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    props: ['boxes', 'classifications', 'product'],
    data() {
        return {
            selected: [],
            color: '#f4f6f8',
    }
}
}
</script>
