<template>
    <div class="container">
        <div class="page-header">
            <h2>Shopping Cart</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="(c, index) of cart" :key="c.id">
                            <td style="width: 20%;">{{ c.name }}</td>
                            <td style="width: 50%;">{{ c.description }}</td>
                            <td style="width: 10%;">{{ c.price }}</td>
                            <td style="width: 20%;">
                                <button class="btn btn-secondary btn-md" @click="removeFromCart(index)">Remove From Cart</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-12" >
                    <h3 class="cart-line">
                        Total <span class="cart-price cart-total">{{ total }}</span>
                    </h3>
                </div>
                <div class="col-md-12 panel-footer row">
                    <div class="col-xs-6 text-left">
                        <div class="previous">
                            <router-link :to="'/productlisting'" class="btn btn-danger btn-md">Continue Shopping</router-link>
                        </div>
                    </div>
                    <div class="col-xs-6 text-right">   
                        <div class="next">   
                           &nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-success btn-md" @click="checkout()">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                name: "Cart",
                cart: [],
            };
        },
        computed: {
            total() {
                this.cart = JSON.parse(localStorage.getItem("cart"))
                return this.cart.reduce((total, p) => {
                    return total + p.price
                }, 0)
            }
        },
        methods: {
            removeFromCart(itemId) {
                const cartItems = JSON.parse(localStorage.getItem("cart"));
                const index = cartItems.findIndex(({ id }) => cartItems.id === itemId);
                cartItems.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(cartItems));
                this.cart = JSON.parse(localStorage.getItem("cart"));
            },
            getCart() {
                if (!localStorage.getItem("cart")) {
                    localStorage.setItem("cart", JSON.stringify([]));
                }
                this.cart = JSON.parse(localStorage.getItem("cart"));
                console.log(this.cart);
            },
            checkout() {
                let url = `/productdata/savecartdata/`;
                axios.get(url, { params: { cart: this.cart} })
                .then((response) => {
                    this.product         = response.data;
                    this.cart            = JSON.parse(localStorage.getItem("cart"));
                    var detailsPage      = this.$router.resolve({ path: '/checkout/'+12});
                    window.location.href = detailsPage.href;
                })
            },
        },
        beforeMount() {
            this.getCart();
        },
    }
</script>