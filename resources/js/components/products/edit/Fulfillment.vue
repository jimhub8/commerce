<template>
<div style="padding: 30px 0;">
    <h1 class="text-center">Fulfillment Information</h1>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex sm6 xs12 offset-sm1>
            <!-- <v-switch v-model="product.active" label="Active" v-if="switch_status" color="primary"></v-switch> -->
            <v-checkbox v-model="product.digital" label="This is a digital product"></v-checkbox>
            <v-checkbox v-model="product.lot" label="This is a lot product"></v-checkbox>
            <v-checkbox v-model="product.dangerous" label="This is classified as dangerous goods"></v-checkbox>
            <v-checkbox v-model="product.has_serial" label="This product has serial numbers"></v-checkbox>
        </v-flex>
        <v-flex xs12 sm3 offset-sm1>
            <v-card :color="color">
                <v-card-title>
                    Heads up!
                </v-card-title>
                <v-card-text>
                    <small>Checking off all that apply will ensure we fulfill your products accurately.</small>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    props: ["product"],
    data() {
        return {
            selected: [],
            color: '#f4f6f8',
        };
    },
};
</script>
