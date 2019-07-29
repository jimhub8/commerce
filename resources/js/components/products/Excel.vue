<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <h3>Import Products via Excel</h3>
                <p>To import your products in Excel we require a SKU number and Item Name.Beyond that you can add extra information. Download our Product Import Template.</p>
            </v-card-title>
            <VDivider />
            <v-card-text>
                <form action="importProducts" method="post" enctype="multipart/form-data">
                    <label for="">Client</label>
                    <select class="custom-select" name="client">
                        <option selected>Select a Client</option>
                        <option v-for="item in clients.data" :key="item.id" :value="item.id">{{ item.display_name }}</option>
                    </select>
                    <div style="height: 10px;"></div>
                    <VDivider />
                    <div class="large-12 medium-12 small-12 filezone">
                        <input name="products" type="file" id="files" ref="files" multiple v-on:change="handleFiles()" />
                        <p>
                            Drop your files here <br>or click to search
                        </p>
                    </div>
                    <!-- <input type="file" name="products" id="input" /> -->
                    <input type="hidden" name="_token" :value="csrf">
                    <div v-for="(file, key) in files" class="file-listing">
                        <img class="preview" v-bind:ref="'preview'+parseInt(key)" />
                        {{ file.name }}
                        <div class="success-container" v-if="file.id > 0">
                            Success
                        </div>
                        <div class="remove-container" v-else>
                            <a class="remove" v-on:click="removeFile(key)">Remove</a>
                        </div>
                    </div>
                    <v-card-actions>
                        <v-btn flat color="primary" @click="files=[]" v-show="files.length > 0">clear</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn type="submit" :disabled="loading" :loading="loading" flat color="primary">Submit</v-btn>
                    </v-card-actions>
                </form>
            </v-card-text>
            <VCardActions>
                <v-btn color="primary" flat @click="close">Close</v-btn>
            </VCardActions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            dialog: false,
            files: [],
            loading: false,
            tickets: [{
                name: "test"
            }],
            headers: ["Test header"]
        }
    },
    methods: {
        close() {
            this.dialog = false
        },

        handleFiles() {
            let uploadedFiles = this.$refs.files.files;

            for (var i = 0; i < uploadedFiles.length; i++) {
                this.files.push(uploadedFiles[i]);
            }
            this.getImagePreviews();
        },
        getImagePreviews() {
            for (let i = 0; i < this.files.length; i++) {
                if (/\.(jpe?g|png|gif)$/i.test(this.files[i].name)) {
                    let reader = new FileReader();
                    reader.addEventListener(
                        "load",
                        function () {
                            this.$refs["preview" + parseInt(i)][0].src = reader.result;
                        }.bind(this),
                        false
                    );
                    reader.readAsDataURL(this.files[i]);
                } else if (/\.(csv|xls)$/i.test(this.files[i].name)) {
                    this.$nextTick(function () {
                        this.$refs["preview" + parseInt(i)][0].src = "/storage/img/csv.png";
                    });
                } else if (/\.(pdf)$/i.test(this.files[i].name)) {
                    this.$nextTick(function () {
                        this.$refs["preview" + parseInt(i)][0].src = "/storage/img/pdf.png";
                    });
                } else {
                    this.$nextTick(function () {
                        this.$refs["preview" + parseInt(i)][0].src =
                            "/storage/img/file.png";
                    });
                }
            }
        },
        getClients() {
            this.$store.dispatch('getClients');
        },
    },
    created() {
        eventBus.$on('openExcelProduct', data => {
            this.dialog = true
            this.getClients()
        })
    },
    computed: {
        clients() {
            return this.$store.getters.clients
        },
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

h3 {
    color: #4e5c73 !important;
    display: block !important;
    font-size: 2rem !important;
    line-height: 1.25em !important;
    padding-left: 2rem !important;
    padding-right: 2rem !important;
    font-weight: 700 !important;
    margin: auto !important;
    border-bottom: 1px solid #e5e5e5;
    padding-bottom: 10px !important;
}

p {
    color: #7e90ad !important;
    padding-left: 2.5rem !important;
    padding-right: 2.5rem !important;
    font-size: 1.0625rem !important;
    line-height: 1.4em !important;
    max-width: 470px !important;
    margin-left: auto !important;
    font-weight: 500 !important;
    margin-right: auto !important;
    display: block !important;
    text-align: center !important;
    padding-top: 20px !important;
}

input[type="file"] {
    opacity: 0;
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
}

.filezone {
    outline: 2px dashed grey;
    outline-offset: -10px;
    background: #ccc;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px;
    position: relative;
    cursor: pointer;
}

.filezone:hover {
    background: #c0c0c0;
}

.filezone p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 50px 50px 50px;
}

div.file-listing img {
    max-width: 90%;
}

div.file-listing {
    margin: auto;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

div.file-listing img {
    height: 100px;
}

div.success-container {
    text-align: center;
    color: green;
}

div.remove-container {
    text-align: center;
}

div.remove-container a {
    color: red;
    cursor: pointer;
}

a.submit-button {
    display: block;
    margin: auto;
    text-align: center;
    width: 200px;
    padding: 10px;
    text-transform: uppercase;
    background-color: #ccc;
    color: white;
    font-weight: bold;
    margin-top: 20px;
}

#image {
    width: 90%;
    height: 150px;
}
</style>
