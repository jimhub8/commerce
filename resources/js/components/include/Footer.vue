<template>
<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
    <div class="flex-w p-b-90">
        <div class="w-size6 p-t-30 p-l-15 p-r-15 respon3">
            <h4 class="s-text12 p-b-30">
                GET IN TOUCH
            </h4>

            <div>
                <p class="s-text7 w-size27">
                    Our phone number: <b>+254792877803</b>
                </p>
                Social media
                <hr>
                <div class="flex-m p-t-30">
                    <a href="#" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
                    <a href="#" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
                    <a href="#" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
                    <a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
                    <a href="#" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
                </div>
                <br>
                <h4>Contact us</h4>
                <hr>
                <div class="form-group">
                    <input type="text" class="form-control" v-model="form.email" placeholder="Your email">
                    <br>
                    <textarea v-model="form.message" cols="10" rows="5" class="form-control" placeholder="message"></textarea>
                </div>
            </div>
        </div>

        <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
            <h4 class="s-text12 p-b-30">
                Help Center
            </h4>

            <ul>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        How to shop on Dellmat
                    </a>
                </li>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        Track order
                    </a>
                </li>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        Shipping and delivery
                    </a>
                </li>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        Privacy policy
                    </a>
                </li>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        Return policy
                    </a>
                </li>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        FAQ's
                    </a>
                </li>
            </ul>
        </div>

        <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
            <h4 class="s-text12 p-b-30">
                Account
            </h4>

            <ul>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        Become a seller
                    </a>
                </li>
                <li class="p-b-9">
                    <a href="#" class="s-text7">
                        Become a buyer
                    </a>
                </li>
            </ul>
        </div>

        <div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
            <h4 class="s-text12 p-b-30">
                Best ratings
            </h4>

            <ul>
                <li class="p-b-9" v-for="rating in ratings" :key="rating.id">
                    <a href="#" class="s-text7">
                        {{ rating.product_name }}
                        <span>
                            <v-rating color="orange" readonly small v-model="rating.rating"></v-rating>
                        </span>
                    </a>
                </li>

            </ul>
        </div>

        <div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
            <h4 class="s-text12 p-b-30">
                Newsletter
            </h4>
            <div class="effect1 w-size9">
                <input class="s-text7 bg6 w-full p-b-5" type="text" name="email" placeholder="email@example.com">
                <span class="effect1-line"></span>
            </div>

            <div class="w-size2 p-t-20">
                <!-- Button -->
                <button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    <div class="t-center p-l-15 p-r-15">
        <a href="#">
            <img class="h-size2" src="/storage/icons/paypal.png" alt="IMG-PAYPAL">
        </a>

        <a href="#">
            <img class="h-size2" src="/storage/icons/visa.png" alt="IMG-VISA">
        </a>

        <a href="#">
            <img class="h-size2" src="/storage/icons/mastercard.png" alt="IMG-MASTERCARD">
        </a>

        <a href="#">
            <img class="h-size2" src="/storage/icons/express.png" alt="IMG-EXPRESS">
        </a>

        <a href="#">
            <img class="h-size2" src="/storage/icons/discover.png" alt="IMG-DISCOVER">
        </a>

        <div class="t-center s-text8 p-t-20">
            Copyright © {{ today }} All rights reserved.
        </div>
    </div>
</footer>
</template>

<script>
export default {
    data() {
        return {
            form: {},
            categories: [],
            ratings: [],
            brands: [],
            today: new Date().getFullYear(),
        }
    },
    mounted() {
        axios
            .get("/catLimit")
            .then(response => {
                this.categories = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });

        axios
            .get("/brands")
            .then(response => {
                this.brands = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });

        axios
            .get("/bestRated")
            .then(response => {
                this.ratings = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });
    },
}
</script>

<style scoped>
.respon4 a {
    text-decoration: navajowhite !important;
}
</style>
