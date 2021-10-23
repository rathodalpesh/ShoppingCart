<template>
    <div class="container">
        <div class="page-header">
            <h2>Product List</h2>
        </div>
        <div v-if="products.length" v-for="product in products" v-bind:key="product.id" class="table-content">
            <div class="row form-group">
                <div class="col-md-4 how-img">
                    <img v-bind:src="`uploads/products/${product.product_image}`" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <router-link :to="{path: 'uploads/product/'+product.id }"><h4>{{ product.name }}</h4></router-link>
                    <p class="text-muted">{{ product.description }}</p>
                    <p class="text-muted">{{ product.price }}</p>
                    <button class="btn btn-success" @click="addProductToCart(product.id)">Add to Cart</button>
                    <button class="btn btn-primary">Add to Wishlist</button>
                </div>
            </div>
        </div>
        <div v-else class="table-content">
            <div class="table-item">No results found</div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                products: [],
            }
        },
        created() {
            axios.get('/productdata/getList')
            .then((response) => {
                this.products = response.data.products;
            })
            .catch(error => {
                console.log(error);
            })
        },
        methods: {
            getAvatar(avatar){
                return "public/uploads/products/"+avatar;
            },
            addProductToCart(itemId) {
                const item = this.products.find(({ id }) => id === itemId);
                if (!localStorage.getItem("cart")) {
                    localStorage.setItem("cart", JSON.stringify([]));
                }
                const cartItems = JSON.parse(localStorage.getItem("cart"));
                cartItems.push(item);
                localStorage.setItem("cart", JSON.stringify(cartItems));
                this.cart = JSON.parse(localStorage.getItem("cart"));
                router.push("cart")
            }
        },
    }
</script>