<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="530px">
        <VCard>
            <v-card-text>
                <v-radio-group>
                    <v-layout row wrap>
                        <v-flex sm3 offset-sm1>
                            <v-hover>
                                <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="400" @click="openCreate('Excel')">
                                    <v-radio label="Import from Excel" value="excel"></v-radio>
                                    <p class="text-center" style="font-size: 11px;color: gray;">We will provide a template</p>
                                </v-card>
                            </v-hover>
                        </v-flex>
                        <v-flex sm3 offset-sm3>
                            <v-hover style="margin-left: 40px !important;">
                                <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mx-auto" width="400" @click="openCreate('Manually')">
                                    <v-radio label="Add product manually" value="manually"></v-radio>
                                    <p class="text-center" style="font-size: 11px;color: gray;">Add products one-by-one</p>
                                </v-card>
                            </v-hover>
                        </v-flex>
                    </v-layout>
                </v-radio-group>
            </v-card-text>
            <VCardActions>
                <v-btn color="primary" flat @click="close">Close</v-btn>
            </VCardActions>
        </VCard>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            dialog: false
        }
    },
    methods: {
        close() {
            this.dialog = false
        },
        openCreate(data) {
            this.dialog = false
            eventBus.$emit('responseChooseEvent', data)
        },

    },
    created() {
        eventBus.$on('openChooseupload', data => {
            this.dialog = true
        })
    },
}
</script>

<style scoped>
.v-input--radio-group--column .v-radio:not(:last-child):not(:only-child),
.v-radio {
    display: flex;
    cursor: pointer;
    min-width: 150px;
    min-height: 200px;
    width: 47%;
    /* -webkit-box-shadow: 0px 4.5px 15px -3.5px rgba(0, 0, 0, 0.75);
    box-shadow: 0px 4.5px 15px -3.5px rgba(0, 0, 0, 0.75); */
    border-radius: 6px;
    padding: 1.5em;
}
</style>
