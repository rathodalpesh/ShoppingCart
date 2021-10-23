<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.vueproductlist');
    }

    /**
     *  @author :  Alpesh Rathod
     *  @param  : Request
     *  @uses   : Get listing of products
     *  @return : JSON of data
     **/
    public function getList(Request $request)
    {
        $products = Product::where('status',1)->get();
        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     *  @author :  Alpesh Rathod
     *  @param  : Request
     *  @uses   : Get Product Information
     *  @return : JSON of data
     **/
    public function getProductDetails(Request $request)
    {
        $productFetch = Product::find($request->id);
        return response()->json($productFetch);
    }

    /**
     *  @author :  Alpesh Rathod
     *  @param  : Request
     *  @uses   : Get Product Information
     *  @return : JSON of data
     **/
    public function saveCartData(Request $request)
    {
        $temp     = array();
        foreach($request->cart as $k => $cart) {
            $decodeJson = json_decode($cart);
            $temp[$k]['id']    = $decodeJson->id;
            $temp[$k]['price'] = $decodeJson->price;
        }
        
        foreach($temp as $k => $data) {
            $addOrder             = new Order();
            $addOrder->user_id    = Auth::user()->id;
            $addOrder->product_id = $data['id'];
            $addOrder->price      = $data['price'];
            $addOrder->created_at = date('Y-m-d H:i:s');
            $addOrder->updated_at = date('Y-m-d H:i:s');
            $addOrder->save();
        }
        return response()->json(true);
    }
}