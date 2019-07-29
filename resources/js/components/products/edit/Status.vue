<template>
<v-item-group>
    <h1 class="text-center">Status</h1>
    <VDivider/>
    <v-container grid-list-md>
        <v-layout wrap>
            <!-- <v-flex xs12 md4>
                <v-item>
                    <v-card slot-scope="{ active, toggle }" :color="active ? 'primary' : ''" class="d-flex align-center" dark width="100" height="90" @click="activeStatus">
                        <v-scroll-y-transition>
                            <div class="display-3 text-xs-center">
                                <p style="font-size: 20px; color: #fff;">Active</p>
                            </div>
                        </v-scroll-y-transition>
                    </v-card>
                </v-item>
            </v-flex>

            <v-flex xs12 md4>
                <v-item>
                    <v-card slot-scope="{ inactive, toggle }" :color="!active ? 'primary' : ''" class="d-flex align-center" dark width="100" height="90" @click="inactiveStatus">
                        <v-scroll-y-transition>
                            <div class="display-3 text-xs-center">
                                <p style="font-size: 20px; color: #fff;">Inactive</p>
                            </div>
                        </v-scroll-y-transition>
                    </v-card>
                </v-item>
            </v-flex> -->
            <v-switch v-model="product.active" label="Active" v-if="switch_status" color="primary"></v-switch>
            <v-switch v-model="product.active" label="Inactive" v-else></v-switch>

        </v-layout>
    </v-container>
</v-item-group>
</template>

<script>
export default {
    props: ['product'],
    data() {
        return {
            active: false,
            switch_status: true
        }
    },
    methods: {
        activeStatus() {
            this.active = true
        },
        inactiveStatus() {
            this.active = false
        },
    },
}
</script>
