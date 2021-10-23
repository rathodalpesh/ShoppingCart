<?php

namespace App\Http\Controllers;

use \Response;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\{Session, Validator};

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.list');
    }

     /**
    *  @author : Alpesh Rathod
    *  @param  : Request
    *  @uses   : Prepare data for attributes listing page
    *  @return : (array) JSON of attribute data
    **/
    public function getList(Request $request)
    {
        $products = Product::all();
        return Datatables::of($products)
                ->addColumn('thumb', function ($products) {
                    if($products->product_image != null){
                        return "<img src='".url('uploads/products/'.$products->product_image)."' width='100' height='100'>";
                    }
                })
                ->addColumn('name', function ($products) {
                    return $products->name;
                })
                ->addColumn('category_name', function ($products) {
                    $getCatName = ProductCategory::find($products->category_id);
                    return $getCatName->cat_name;
                })
                ->addColumn('sub_cat_name', function ($products) {
                    $getSubCatName = ProductSubCategory::find($products->sub_category_id);
                    return $getSubCatName->sub_cat_name;
                })
                ->addColumn('action', function ($products) {
                    $editLink   = '<a href="'. route("product.edit",$products->id).'" class="btn btn-sm btn-clean btn-icon">Edit</a>';
                    $deleteLink = '<a href="javascript:void(0);" class="btn btn-sm btn-clean btn-icon" data-id='.$products->id.' onclick="removeProduct(this);">Delete</a>';
                    return $editLink."|".$deleteLink;
                })->rawColumns(['thumb','name','category_name','sub_cat_name','action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['success'] = Session::get('success');
        $data['error'] = Session::get('error');   
        $data['productCategory'] = ProductCategory::all();
        return view('product.manage',$data);
    }

    private function rules(Request $request): array
    {
        $this->rules = [
            'name'            => 'required',
            'category_id'     => 'required',
            'sub_category_id' => 'required',
            'price'           => 'required||regex:/^\d{1,13}(\.\d{1,4})?$/',
            'product_image'   => 'mimes:jpg,png,gif'
        ];
        return  $this->rules;
    }

    private function messages(): array
    {
        return [
            'name'            => trans("product.name_error"),
            'category_id'     => trans("product.category_id_error"),
            'sub_category_id' => trans("product.sub_category_id_error"),
            'price'           => trans("product.price_error"),
            'product_image.mimes' => trans("product.product_image_error"),
        ];
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), $this->rules($request),  $this->messages());
            if ($validator->fails()) {
                return \Redirect::back()->withInput()->withErrors($validator);
            }

            $fileName = null;
            if (request()->hasFile('product_image')) {
                $file     = request()->file('product_image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/products/', $fileName);    
            }

            $productSave                  = new Product();
            $productSave->status          = !empty($request->status) ? true : false;
            $productSave->name            = $request->name; 
            $productSave->category_id     = $request->category_id;
            $productSave->sub_category_id = $request->sub_category_id;
            $productSave->description     = $request->description;
            $productSave->price           = $request->price;
            $productSave->product_image   = $fileName;
            $productSave->save();

            return redirect()->route("product.create")->with('success', "Product added successfully.");

        } catch (\Exception $e) {
            
            return \Redirect::back()->withInput()->with('error', "Oops, Something went wrong");
        } 
    }

    /**
     * Get the sub category list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubCategory(Request $request)
    {
        $getSubCatData = ProductSubCategory::where('cat_id',$request->category_id)->get();
        $htmlData = "";
        foreach($getSubCatData as $data) {
            $htmlData .= "<option value='".$data->id."'>";
            $htmlData .= $data->sub_cat_name;
            $htmlData .= "</option>";
        }
        return Response::json(['status' => true, 'htmlData' => $htmlData ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['productData']        = $product;
        $data['productCategory']    = ProductCategory::all();
        $data['productSubCategory'] = ProductSubCategory::all();
        return view('product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try{

            $validator = Validator::make($request->all(), $this->rules($request),  $this->messages());
            if ($validator->fails()) {
                return \Redirect::back()->withInput()->withErrors($validator);
            }

            $productSave                  = Product::find($request->id);
            $productSave->status          = !empty($request->status) ? true : false;
            $productSave->name            = $request->name; 
            $productSave->category_id     = $request->category_id;
            $productSave->sub_category_id = $request->sub_category_id;
            $productSave->description     = $request->description;
            $productSave->price           = $request->price;

            if (request()->hasFile('product_image')) {
                $file     = request()->file('product_image');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./uploads/products/', $fileName);
                $productSave->product_image   = $fileName;
            }
            $productSave->save();
            return redirect()->route("product.edit",$request->id)->with('success', "Product updated successfully.");
        } catch (\Exception $e) {
            return \Redirect::back()->withInput()->with('error', "Oops, Something went wrong");
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return Response::json(['status' => true,'success' => 'Product removed successfully.']);
    }
}
