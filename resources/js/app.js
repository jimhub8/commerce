
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue()
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import VueScrollTo from 'vue-scrollto'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
// import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
// import VueCarousel from 'vue-carousel';
import VueLazyload from 'vue-lazyload'
// import JsonExcel from 'vue-json-excel'
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'
import StoreData from './store/store'

Vue.use(VueGoodTablePlugin);
Vue.use(ElementUI, { locale });

Vue.use(VueLazyload)
// Vue.use(VueCarousel);
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(VueScrollTo, {
    container: "body",
    duration: 500,
    easing: "ease",
    offset: 0,
    force: true,
    cancelable: true,
    onStart: false,
    onDone: false,
    onCancel: false,
    x: false,
    y: true
})
// Vue.component('downloadExcel', JsonExcel)
Vue.use(CKEditor);
import Vuex from 'vuex'
Vue.use(Vuex)
const store = new Vuex.Store(StoreData)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Vue.component('example-component', require('./components/ExampleComponent.vue'));

import myApi from './components/api/Api.vue';

import myHeader from './components/include/Header.vue';
import myNavmenu from './components/include/Menu.vue';
import myRegister from './components/register/Register.vue';
import myFooter from './components/include/Footer.vue';
import myNav from './components/include/Headervue.vue';
import myProduct from './components/product/Sliders.vue';
import myAdmProduct from './components/products/Product';
import myHome from './components/home/Home.1.vue';
import productDetail from './components/Shop/Details';
import myShow from './components/home/Show.vue';
// import myslider from './components/product/Sliders.vue';
import myShop from './components/Shop/Shop.vue';
import myCartHome from './components/cart/CartHome.vue';
import myAbout from './components/about/About.vue';
import myFilter from './components/filter/Filter.vue';
import mywishList from './components/wish/Wish.vue';
import CategoryFilter from './components/filter/Category.vue';
import SearchP from './components/Shop/Search';
import myThanks from './components/Shop/Thankyou';
import myunauth from './components/Unauthorized.vue';

// Admin
import myDash from './components/Dashboard.vue';
import myPro from './components/admin/products/Products.vue';
import myMenu from './components/admin/menu/Menu.vue';
import myCategory from './components/admin/category/Category.vue';
import mySubCat from './components/admin/subcategory/SubCat.vue';
import myOrders from './components/admin/orders/Orders.vue';
import myPayment from './components/admin/orders/Payment.vue';
import myPrescription from './components/admin/prescription/Prescription.vue';
import myUsers from './components/admin/users/User.vue';
import myRole from './components/admin/users/roles/Roles.vue';
import myProfile from './components/admin/users/Profile.vue';
import myAdminAbout from './components/admin/about/About.vue';
import myAdminInvoice from './components/admin/invoices/Invoice';
import myAdminCompany from './components/admin/company/Company';
import myAdminCoupon from './components/admin/coupon/Coupon.vue';
import myAdminSize from './components/admin/size/Size.vue';
import myReports from './components/admin/reports/Reports.vue';
import myAccount from './components/admin/client/Client.vue';

import myGroup from './components/group/Groups'
import myGroupShow from './components/group/Product'
import myGroupCreate from './components/group/Create'
import myGroupEdit from './components/group/Edit'

// Clients
import myClientOrders from './components/clients/Orders';

import editProduct from './components/products/Edit.vue'


import myCheckout from './components/admin/checkout'

const routes = [
    // { path: '/example', component: exampleComponent },

    { path: '/', component: myHome },
    { path: '/filter', component: myFilter },
    { path: '/prescriptions', component: myPrescription },
    { path: '/roles', component: myRole },
    { path: '/users', component: myUsers },
    { path: '/profile', component: myProfile },
    { path: '/products', component: myProduct },
    { path: '/shop', component: myShop },
    { path: '/wishList', component: mywishList },
    { path: '/cartHome', component: myCartHome },

    { path: '/about', component: myAbout },
    { path: '/details/:id', component: productDetail, name: 'details' },
    { path: '/category/:id', component: CategoryFilter, name: 'Category' },
    { path: '/search/:search', component: SearchP, name: 'search' },
    { path: '/thankyou', component: myThanks, name: 'thankyou' },
    { path: '/unauthorized', component: myunauth },

    // Admin
    { path: '/dashboard', component: myDash },
    // { path: '/Adminproducts', component: myPro },
    { path: '/AdminMenu', component: myMenu },
    { path: '/Admincategories', component: myCategory },
    { path: '/AdminSubCat', component: mySubCat },
    { path: '/AdminOrders', component: myOrders },
    { path: '/Adminpayments', component: myPayment },
    { path: '/AdminAbout', component: myAdminAbout },
    { path: '/AdminInvoice', component: myAdminInvoice },
    { path: '/AdminCompany', component: myAdminCompany },
    { path: '/coupons', component: myAdminCoupon },
    { path: '/size', component: myAdminSize },
    { path: '/api', component: myApi },
    { path: '/reports', component: myReports },
    { path: '/profile', component: myAccount },

    { path: '/checkout', component: myCheckout, name: 'checkout' },

    // Clients
    { path: '/myOrders', component: myClientOrders },

    { path: '/Adminproducts', component: myAdmProduct },
    { path: '/products/:id', component: editProduct, name: 'editProducts' },



    { path: '/groups', component: myGroup },
    { path: '/groups/:id', component: myGroupShow, name: 'groupShow' },
    { path: '/groupCreate', component: myGroupCreate, name: 'groupCreate' },
    { path: '/groupEdit', component: myGroupEdit, name: 'groupEdit' },
]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})
const app = new Vue({
    el: '#app',
    store,
    router,
    components: {
        myProduct, myNav, myHome, myPro, myPrescription, myHeader, myFooter, myunauth,
        myPayment, myShow, myDash, myCategory, myOrders, myShop, myCartHome,
        myAdminAbout, myAbout, mywishList,myUsers, myRole, CategoryFilter, myAdminCoupon,
        myNavmenu, myAdminSize, myReports, myApi, myAccount, myRegister, myClientOrders,
        myProfile, productDetail, SearchP, myAdminInvoice,myAdminCompany, myMenu, myThanks,
        myAdmProduct, editProduct, myGroup, myGroupCreate, myGroupShow, myGroupEdit, myCheckout
        // myslider

    },
});
