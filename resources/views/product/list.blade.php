@extends('layouts.app')

@push('headerCss')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
@endpush

@section('content')
<div class="container">
    <div class="col-md-12">
        <a href="{{ route('product.create') }}" class="btn btn-primary">{{ trans("product.Add Product")  }}</a>
    </div>
    <div class="col-md-12" id="deleteMsg" style="display: none;">
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>    
            <strong>{{ trans("product.Product deleted successfully")  }}</strong>
        </div>
    </div>
    <div class="col-md-12" style="padding-top: 10px;">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>{{ trans("product.Thumb")  }}</th>
                    <th>{{ trans("product.Name")  }}</th>
                    <th>{{ trans("product.Category")  }}</th>
                    <th>{{ trans("product.Sub Category")  }}</th>
                    <th>{{ trans("product.Action")  }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('footerJs')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
<script type="text/javascript">
    var productList;
    $(document).ready(function(){
        productList = $('#example').DataTable({
            "bDestroy": true,
            "ajax": {
                "url": "{{ route('product.list') }}",
                "data": { "_token": "{{ csrf_token() }}" }
            },
            columns: [
                {data : 'thumb', "name" : 'thumb', sortable: false, 'class':'text-center', 'width':'10%'},
                {data : 'name', "name" : 'name', sortable: true, 'class':'text-center', 'width':'25%'},
                {data : 'category_name', "name" : 'category_name', sortable: true, 'class':'text-center', 'width':'20%'},
                {data : 'sub_cat_name', "name" : 'sub_cat_name', orderable: false, sortable: false, 'class':'text-center', 'width':'20%'},
                {data : 'action', "name" : 'action', sortable: false, 'class':'text-center', 'width':'15%'},
            ],
            order:[1, 'asc'],
            searching: true,
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            } 
        });
    });

    function removeProduct(e) {
        var id = $(e).data("id");
        if (confirm("Do you want to delete this product?")) {
            $.ajax({
                url: "{{ URL('product') }}"+"/"+id,
                type: "DELETE",
                data: {"id": id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if(data.status == true) {
                        $("#deleteMsg").css("display","block");
                        productList.ajax.reload();
                    }
                }
            });
        }
        return false;
    }
</script>
@endpush