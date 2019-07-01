<template>
<v-stepper v-model="e6" vertical>
    <v-stepper-step :complete="e6 > 1" step="1">
        Company Details
        <small>Summarize if needed</small>
    </v-stepper-step>

    <v-stepper-content step="1" style="background: #fff;">
        <v-card color="grey lighten-1" class="mb-5">
            <Company :account="account" :errors="errors"></Company>
        </v-card>
        <v-btn color="primary" @click="companyAdd">Continue</v-btn>
        <v-btn flat @click="cancel">Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step :complete="e6 > 2" step="2">User details</v-stepper-step>

    <v-stepper-content step="2" style="background: #fff;">
        <v-card color="grey lighten-1" class="mb-5">
            <Register :account="account" :errors="errors"></Register>
        </v-card>
        <v-btn color="primary" @click="userAdd">Finish</v-btn>
        <v-btn flat @click="e6 = 1">Back</v-btn>
    </v-stepper-content>
</v-stepper>
</template>

<script>
import Register from './register/Register.vue';
import Company from './register/Company.vue';
export default {
    components: {
        Register,
        Company
    },
    data() {
        return {
            account: {},
            e6: 1,
            errors: {},
            company_id: null
        }
    },
    methods: {
        companyAdd() {
            this.e6 = 2
            //   eventBus.$emit("CompanyEvent");
        },
        userAdd() {
            //   eventBus.$emit("userEvent", this.company_id);
            this.loading = true
            axios.post('/vendor_user', this.$data.account).
            then((response) => {
                    this.loading = false
                    this.$emit('alertRequest', 'Account Created');
                    eventBus.$emit("userResponse");
                })
                .catch((error) => {
                    this.loading = false
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else {
                        eventBus.$emit('errorEvent', 'Please confirm if all fields are filled')
                        this.e6 = 1
                        this.errors = error.response.data.errors
                    }
                    // console.log()
                })
        },
        cancel() {
            window.location.replace('/')
        }
    },
    created() {
        eventBus.$on('userResponse', data => {
            window.location.replace('/thankyou')
        })
        eventBus.$on('companyResponse', data => {
            this.e6 = 2
            // this.userAdd(data)
            this.company_id = data
        })
    },
}
</script>
