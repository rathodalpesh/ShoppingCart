<template>
    <div class="container">
        <div class="page-header text-center">
            <h2>Checkout Completed</h2>
        </div>
        <div class="alert alert-success text-center">
            <h3>Thank you. Your order has been received.</h3>
        </div>
        <div class="row">
            <div class="col">
                <strong>Order Number</strong>
                <div>{{ orderData }}</div>
            </div>
            <div class="col">
                <strong>Date purchased</strong>
                <div>ads</div>
            </div>
            <div class="col">
                <strong>Total Payable</strong>
                <div>ads</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            orderData: ""
        }
    },
    created() {
        localStorage.removeItem("cart");
        this.getOrderDetails(this.$route.params.orderid);
    },
    methods: {
        getOrderDetails: function(orderid) {
            this.orderData = orderid;
            console.log(this.orderData);
        }
    }
}
</script>