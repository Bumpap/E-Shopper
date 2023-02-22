@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                THÊM SẢN PHẨM
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
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên sản phẩm</label>
                        <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giá sản phẩm</label>
                        <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                        <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                        <textarea style="resize: none;" rows="8" name="product_desc" class="form-control" id="exampleInputPassword1" placeholder="Mô tả sản phẩm"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                        <textarea style="resize: none;" rows="8" name="product_content" class="form-control" id="exampleInputPassword1" placeholder="Nội dung danh mục"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Danh mục sản phẩm</label>
                        <select name="product_status" class="form-control input-sm m-bot15">
                            <option value="0">Men</option>
                            <option value="1">Woman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Thương hiệu sản phẩm</label>
                        <select name="product_status" class="form-control input-sm m-bot15">
                            <option value="0">On</option>
                            <option value="1">Off</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Hiển thị</label>
                        <select name="product_status" class="form-control input-sm m-bot15">
                            <option value="0">Ẩn</option>
                            <option value="1">Hiện</option>
                        </select>
                    </div>
                    <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                </form>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
