import Cart from './components/Cart';
import ProductListComponent from './components/ProductListComponent';
import ProductDetails from './components/ProductDetails';
import Checkout from './components/Checkout';

export const routes = [
    { path: '/', name: "mainprodutlist", component:ProductListComponent },
    { path: '/cart', name: "shoppingcart", component:Cart },
    { path: '/productlisting', name: "productlisting", component:ProductListComponent },
    { path: '/product/:id', name: 'Product', component: ProductDetails},
    { path: '/checkout/:orderid', name: "checkoutpage", component:Checkout },
];