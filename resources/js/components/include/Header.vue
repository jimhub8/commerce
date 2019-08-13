<template>
<div>
    <v-app id="inspire">
        <!-- temporary -->
        <v-navigation-drawer right temporary v-model="right" fixed></v-navigation-drawer>
        <!-- temporary -->
        <v-navigation-drawer fixed :color="color" :clipped="$vuetify.breakpoint.lgAndUp" app v-model="drawer">
            <v-list dense id="navigation">
                <v-img :aspect-ratio="16/9" src="storage/landS.jpg">
                    <v-layout pa-2 column fill-height class="lightbox white--text">
                        <v-spacer></v-spacer>
                        <v-flex shrink>
                            <div class="subheading">{{ user.name }}</div>
                            <div class="body-1">{{ user.email }}</div>
                        </v-flex>
                    </v-layout>
                </v-img>
                <template>
                    <v-card>
                        <!-- <v-card style="background: url('storage/ps/landS.jpg')"> -->
                        <router-link to="/dashboard" class="v-list__tile v-list__tile--link" v-if="user.can['view dashboard']">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">dashboard</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Dashboard</div>
                            </div>
                        </router-link>

                        <router-link to="/Adminmenu" class="v-list__tile v-list__tile--link" v-if="user.can['view main category']">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">dialpad</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Main Categories</div>
                            </div>
                        </router-link>
                        <router-link to="/Admincategories" class="v-list__tile v-list__tile--link" v-if="user.can['view category']">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">settings</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Categories</div>
                            </div>
                        </router-link>
                        <router-link to="/AdminSubCat" class="v-list__tile v-list__tile--link" v-if="user.can['view subcategory']">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">account_circle</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Subcategories</div>
                            </div>
                        </router-link>

                        <v-list-group prepend-icon="account_circle" v-if="user.can['view products']">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>Products</v-list-tile-title>
                            </v-list-tile>
                            <router-link to="/Adminproducts" class="v-list__tile v-list__tile--link" v-if="user.can['view products']">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">dialpad</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">My Products</div>
                                </div>
                            </router-link>
                            <router-link to="/groups" class="v-list__tile v-list__tile--link" v-if="user.can['view products']">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">folder</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Product With variants</div>
                                </div>
                            </router-link>
                        </v-list-group>

                        <router-link to="/AdminCompany" class="v-list__tile v-list__tile--link" v-if="user.can['view company']">
                            <div class="v-list__tile__action"><i aria-hidden="true" class="icon material-icons">account_circle</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Companies
                                </div>
                            </div>
                        </router-link>
                        <router-link to="/coupons" class="v-list__tile v-list__tile--link" v-if="user.can['view coupons']">
                            <div class="v-list__tile__action"><i aria-hidden="true" class="icon material-icons">book</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Coupons
                                </div>
                            </div>
                        </router-link>
                        <router-link to="/size" class="v-list__tile v-list__tile--link" v-if="user.can['view sizes']">
                            <div class="v-list__tile__action"><i aria-hidden="true" class="icon material-icons">book</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Sizes
                                </div>
                            </div>
                        </router-link>
                        <router-link to="/profile" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" class="icon material-icons">account_circle</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Profile
                                </div>
                            </div>
                        </router-link>
                        <v-list-group prepend-icon="dialpad" v-if="user.can['view orders']">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>Orders</v-list-tile-title>
                            </v-list-tile>
                            <router-link to="/AdminOrders" class="v-list__tile theme--light" style="text-decoration: none" v-if="user.can['view orders']">
                                <v-list-tile-action>
                                    <v-icon>map</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Manage Orders</v-list-tile-title>
                            </router-link>
                            <!-- <router-link to="/Adminpayments" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>attach_money</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Manage Payments</v-list-tile-title>
                            </router-link> -->
                        </v-list-group>

                        <v-list-group prepend-icon="account_circle" v-if="user.can['view users', 'view roles']">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>User&Roles</v-list-tile-title>
                            </v-list-tile>

                            <router-link to="/users" class="v-list__tile theme--light" style="text-decoration: none" id="link-router" v-if="user.can['view users']">
                                <v-list-tile-action>
                                    <v-icon>people_outline</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Manage Users</v-list-tile-title>
                            </router-link>
                            <router-link to="/roles" class="v-list__tile theme--light" style="text-decoration: none" v-if="user.can['view roles']">
                                <v-list-tile-action>
                                    <v-icon>gavel</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Manage Roles</v-list-tile-title>
                            </router-link>
                        </v-list-group>
                        <router-link to="/reports" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" class="icon material-icons">book</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Reports
                                </div>
                            </div>
                        </router-link>
                    </v-card>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark app :color="color" :clipped-left="$vuetify.breakpoint.lgAndUp" fixed>
            <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>{{ company.company_name }}
                <img :src="company.logo" alt="" style="width: 60px; height: 60px; border-radius: 25%;">
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-divider vertical></v-divider>
            <Notifications :user="user"></Notifications>
            <Logout :user="user"></Logout>
            <!-- <a href="/" class="v-btn v-btn--flat theme--dark white--text">Site</a> -->
            <v-divider vertical></v-divider>
            <!-- <chattyNoty :user="user"></chattyNoty> -->
            <!-- <v-icon @click.stop="right = !right" style="cursor: pointer">apps</v-icon> -->
            <!-- <form action="/logout" method="post">
                <input type="hidden" name="_token" :value="csrf">
                <v-btn flat color="white" type="submit">Logout</v-btn>
            </form>

            <form action="/logoutOther" method="get">
                <input type="hidden" name="_token" :value="csrf">
                <v-tooltip bottom>
                    <v-btn slot="activator" icon class="mx-0" type="submit">
                        <i class="fa fa-sign-out"></i>
                    </v-btn>
                    <span>Logout other devices</span>
                </v-tooltip>
            </form> -->
        </v-toolbar>
    </v-app>
    <v-snackbar :timeout="timeout" bottom="bottom" :color="Scolor" right="right" v-model="snackbar">
        {{ message }}
        <v-icon dark right>check_circle</v-icon>
    </v-snackbar>
</div>
</template>

<script>
import Notifications from "../notification/Notification";
import Logout from "./Logout";
export default {
    components: {
        Notifications,
        Logout
    },
    props: ["user", 'company'],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            color: "rgb(25, 117, 210)",
            dialog: false,
            drawer: true,
            right: null,
            snackbar: false,
            timeout: 5000,
            Scolor: "",
            message: "Success",
            notifications: []
        };
    },
    methods: {
        openShipment() {
            this.dialog = true;
        },
        close() {
            this.dialog = false;
        },

        showalert() {
            this.message = "success";
            this.Scolor = "black";
            this.snackbar = true;
        },

        showerror(data) {
            this.message = data;
            this.Scolor = "red";
            this.snackbar = true;
        }
    },
    created() {
        eventBus.$on("alertRequest", data => {
            this.showalert();
        });

        eventBus.$on("errorEvent", data => {
            this.showerror(data);
        });
    },
    mounted() {
        // axios.get('/notifications')
        //     .then((response) => {
        //         this.notifications = response.data
        //     })
        //     .catch((error) => {
        //         this.errors = error.response.data.errors
        //     })
    }
};
</script>

<style scoped>
.v-expansion-panel__container:hover {
    border-radius: 10px !important;
    width: 90% !important;
    margin-left: 15px !important;
    background: #e3edfe !important;
    color: #1a73e8 !important;
}

.theme--light {
    background-color: #212120 !important;
    /* background: url('storage/logo1.jpg') !important; */
    color: #fff !important;
}
</style>
