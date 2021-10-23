@extends('layouts.app')

@push('headerCss')
<style>
    .required, .lblSpan {
        color: red;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="col-lg-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
        @endif
    </div>
    <div class="col-lg-12">
        <form action="{{ route('product.update',$productData->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $productData->id }}"/>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Name")  }}<span class="lblSpan">*</span></label>
                <div class="col-lg-4">
                    <input type="text" name="name" class="form-control" id="name" value="{{ $productData->name }}"/>
                    @if ($errors->has("name"))
                        <span class=" form-text required">{{__($errors->first('name'))}}</span>
                    @else
                        <span class="form-text" id="heading_titlereply_to_email_validate" ></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Category")  }}<span class="lblSpan">*</span></label>
                <div class="col-lg-4">
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">{{ trans("product.Select Product Category")  }}</option>
                        @foreach ($productCategory as $pc)
                            <option value="{{ $pc->id }}" @if( $productData->category_id == $pc->id ) selected="selected" @endif>{{ $pc->cat_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("category_id"))
                        <span class=" form-text required">{{__($errors->first('category_id'))}}</span>
                    @else
                        <span class="form-text" id="heading_titlereply_to_email_validate" ></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Subcategory")  }}<span class="lblSpan">*</span></label>
                <div class="col-lg-4">
                    <select class="form-control" name="sub_category_id" id="sub_category_id">
                        @foreach ($productSubCategory as $psc)
                            <option value="{{ $psc->id }}" @if( $productData->sub_category_id == $psc->id ) selected="selected" @endif>{{ $psc->sub_cat_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("sub_category_id"))
                        <span class="form-text required">{{__($errors->first('sub_category_id'))}}</span>
                    @else
                        <span class="form-text" id="heading_titlereply_to_email_validate" ></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Description")  }}</label>
                <div class="col-lg-4">
                    <textarea name="description" class="form-control">{{ $productData->description }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Price")  }}<span class="lblSpan">*</span></label>
                <div class="col-lg-4">
                    <input type="text" name="price" class="form-control" id="price" value="{{ $productData->price }}"/>
                    @if ($errors->has("price"))
                        <span class="form-text required">{{__($errors->first('price'))}}</span>
                    @else
                        <span class="form-text" id="heading_titlereply_to_email_validate" ></span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Image")  }}</label>
                <div class="col-lg-4">
                    <input type="file" name="product_image" id="product_image"/>
                    @if ($errors->has("product_image"))
                        <span class="form-text required">{{__($errors->first('product_image'))}}</span>
                    @else
                        <span class="form-text" id="heading_titlereply_to_email_validate" ></span>
                    @endif
                    @if($productData->product_image != null)
                        <img src="{{ url('uploads/products/'.$productData->product_image) }}" alt="" width="200" height="200">
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">{{ trans("product.Status")  }}</label>
                <div class="col-lg-4">
                    <input type="checkbox" name="status" value="1" @if($productData->status == "1") checked="checked" @endif>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <input type="submit" class="btn btn-success" id="submit_btn" value="{{ trans("product.Save")  }}"/>
                    <a href="{{ route('home') }}" class="btn btn-danger">{{ trans("product.Cancel")  }}</a>
                </div>
            </div>
        </form>
    </div> 
</div>
@endsection

@push('footerJs')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("change","#category_id", function() {
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route("product.subcategory.list") }}',
                type: 'GET',
                data: {"category_id": category_id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    console.log(data.htmlData);
                    if( data.status == true ) {
                        $("#sub_category_id").html(data.htmlData);
                    }
                }
            });
        });
    });
</script>
@endpush