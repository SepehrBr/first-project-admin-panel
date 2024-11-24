@component('admin.layouts.content', [ 'title' => 'Products Panel'])

@slot('script')
    <script>
        // uploader script
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('button-image').addEventListener('click', (event) => {
                event.preventDefault();
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
        });
        // set file link
        function fmSetLink($url) {
            document.getElementById('image_label').value = $url;
        }

    </script>
@endslot

@slot('breadcrumb')
<li class="breadcrumb-item active">Edit Product</li>
<li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.products.update', ['product' => $product->id ])}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputTitle" class="col-sm-2 control-label">Product Title</label>
                            <input id="inputTitle" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $product->title) }}" required autocomplete="title" autofocus placeholder="Add Product's Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="inputDescription" class="col-sm-2 control-label">Product Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="3" name="description"  required autocomplete="description" autofocus placeholder="Add Product's Description">{{ old('description', $product->description) }}</textarea>
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" col-sm-10">
                            <label class="control-label col-sm-2 control-label" for="inputInventory">Product Inventory</label>
                            <input type="number" id="inputInventory" class="form-control @error('inventory') is-invalid @enderror" name="inventory" value="{{ old('inventory', $product->inventory) }}" required autocomplete="inventory" autofocus placeholder="Add Product's Inventory" />
                            @error('inventory')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 ">
                            <label class="control-label col-sm-2" for="inputPrice">Product Price</label>
                            <i class="fas fa-dollar-sign trailing"></i>
                            <input type="number" id="inputPrice" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" required autocomplete="price" placeholder="Add Product's Price"/>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 ">
                            <label class="col-sm-2 control-label">Upload Image</label>
                            {{-- <div class="input-group">
                                <input type="text" id="image_label" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ $product->image }}">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" id="button-image">Select</button>
                                </div>
                            </div>
                            <hr> --}}
                            <input type="file" name="file" id="file" class="form-control">
                            <img src="{{$product->image}}" class="w-25">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category-product" class="col-sm-2 control-label">Add To</label>
                        <select name="categories[]" id="category-product" class="form-control" multiple>
                            @foreach (\App\Models\Category::all() as $category)
                                <option value="{{$category->id}}" {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }} >{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Edit Product</button>
                    <a href="{{route('admin.products.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
