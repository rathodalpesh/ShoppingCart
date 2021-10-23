<template>
  <div class="container">
    <div class="row form-group">
      <div class="col-md-6 how-img">
          <img v-bind:src="`uploads/products/${product.product_image}`" class="img-fluid">
      </div>
      <div class="col-md-6">
          <h2><strong>{{ product.name }}</strong></h2>
          <p class="text-muted">{{ product.description }}</p>
          <p class="text-muted">{{ product.price }}</p>
          <button class="btn btn-success" @click="addProductToCart(product.id)">Add to Cart</button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        product : []
      }
    },
    mounted : function(){
      let url = `/productdata/getproductdetail/`;
      axios.get(url, { params: { id: `${this.$route.params.id}`} })
      .then((response) => {
        this.product = response.data;
      })
    },
    methods: {
      addProductToCart(itemId) {
        const item = this.products.find(({ id }) => id === itemId);
        if (!localStorage.getItem("cart")) {
            localStorage.setItem("cart", JSON.stringify([]));
        }
        const cartItems = JSON.parse(localStorage.getItem("cart"));
        cartItems.push(item);
        localStorage.setItem("cart", JSON.stringify(cartItems));
        this.cart = JSON.parse(localStorage.getItem("cart"));
        console.log(cartItems);
      }
    },
  }
</script>