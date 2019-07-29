<template>
<div>
    <input type="file" id="input" @input="upload" />
    <v-btn color="primary" @click="uploadFile">uploadFile</v-btn>
</div>
</template>

<script>
import readXlsxFile from 'read-excel-file'

export default {
    data() {
        return {
            rows: [],
            excel_headers: [],
        }
    },
    methods: {
        upload() {
            const input = document.getElementById('input')
            input.addEventListener('change', () => {
                readXlsxFile(input.files[0]).then((rows) => {
                    console.log(rows);
                    this.excel_headers = rows.shift()
                    this.rows = rows.splice(0)

                    // `rows` is an array of rows
                    // each row being an array of cells.
                })
            })
        },
        uploadFile() {
            axios.post('/importProducts', {
                rows: this.$data.rows,
                excel_headers: this.$data.excel_headers
            }).then((response) => {
                console.log(response);
            }).catch((error) => {
                alert('error')
                // console.log(error.response);
                this.loading = false

            })
        }
    },
}
</script>

<style scoped>

</style>
