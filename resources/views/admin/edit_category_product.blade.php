@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                CẬP NHẬT DANH MỤC SẢN PHẨM
            </header>
            <?php

                use Illuminate\Support\Facades\Session;

                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message', null);
                }
            ?>
            <div class="panel-body">
                @foreach($edit_category_product as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}"
                    method="post">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên danh mục</label>
                        <input type="text" value="{{ $edit_value->category_name }}" name="category_product_name"
                        class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mô tả danh mục</label>
                        <textarea style="resize: none;" rows="8"name="category_product_desc"
                        class="form-control" id="exampleInputPassword1">{{ $edit_value->category_desc }}</textarea>
                    </div>
                    <button type="submit" name="update_category_product" class="btn btn-info"
                    onclick="return confirm('Are you sure to update?')">Cập nhật danh mục</button>
                </form>
                </div>
                @endforeach
            </div>
        </section>

    </div>
</div>
@endsection
