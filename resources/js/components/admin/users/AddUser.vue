<template>
<v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" color="purple darken-2" label="Full name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" :rules="emailRules" color="blue darken-2" label="Email" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </v-flex>
                                    <!-- <v-flex xs12 sm6>
                                        <v-text-field :append-icon="e1 ? 'visibility_off' : 'visibility'" :type="e1 ? 'password' : 'text'" v-model="form.password" name="input-10-2" label="Enter your password" hint="At least 6 characters" min="8" value="" class="input-group--focused"></v-text-field>
                                        <small class="has-text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                                    </v-flex> -->
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.address" color="blue darken-2" label="Address" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.city" color="blue darken-2" label="City" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small>
                                    </v-flex>
                                    <!-- <v-flex xs12 sm6>
                                        <v-text-field v-model="form.country" color="blue darken-2" label="Country" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.country">{{ errors.country[0] }}</small>
                                    </v-flex> -->
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" color="blue darken-2" label="Phone" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </v-flex>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-6 col-form-label text-md-right" for="">Role</label>
                                        <select class="custom-select custom-select-md col-md-12" v-model="form.role_id">
                                        <option v-for="roles in AllRoles" :key="roles.id" :value="roles.name">{{ roles.name }}</option>
                                    </select>
                                        <small class="has-text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-6 col-form-label text-md-right" for="">Company</label>
                                        <select class="custom-select custom-select-md col-md-12" v-model="form.company">
                                        <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.company_name }}</option>
                                    </select>
                                        <small class="has-text-danger" v-if="errors.company">{{ errors.company[0] }}</small>
                                    </div>
                                </v-layout>
                                <v-layout wrap>
                                    <!-- <div> -->
                                    <v-flex v-for="perm in permissions" :key="perm.id" xs6 sm6>
                                        <v-checkbox v-model="selected" :label="perm.name" :value="perm.name"></v-checkbox>
                                    </v-flex>
                                    <!-- </div> -->
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                    <div v-show="loader" style="text-align: center; width: 100%;">
                        <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
                    </div>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['openAddRequest', 'AllBranches', 'AllRoles', 'companies'],
    data() {
        const defaultForm = Object.freeze({
            name: '',
            // password: '',
            email: '',
            phone: '',
            branch: '',
            address: '',
            company: '',
            // country: '',
        })
        return {
            loading: false,
            errors: [],
            selected: [],
            permissions: [],
            defaultForm,
            loader: false,
            e1: true,
            form: Object.assign({}, defaultForm),
            emailRules: [
                v => {
                    return !!v || 'E-mail is required'
                },
                v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
            ],
            rules: {
                name: [val => (val || '').length > 0 || 'This field is required']
            },
        }
    },
    methods: {
        save() {
            this.loading = true
            axios.post('/users', this.$data.form).
            then((response) => {
                    this.loading = false
                    // console.log(response);
                    this.$parent.Allusers.push(response.data)
                    this.close();
                    // this.resetForm();
                    this.$emit('alertRequest');
                })
                .catch((error) => {
                    this.loading = false
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else {
                        this.errors = error.response.data.errors
                    }
                    // console.log()
                })
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm)
            this.$refs.form.reset()
        },
        close() {
            this.$emit('closeRequest')
        },
    },
    mounted() {
        axios.get('/getPermissions')
            .then((response) => {
                console.log(response.data)
                this.permissions = response.data
            })
            .catch((errors) => {
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                }
                this.errors = error.response.data.errors
            })
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                // this.form.zipcode &&
                this.form.branch &&
                this.form.address &&
                this.form.city
            )
        },
    },
    mounted() {

    }
}
</script>
