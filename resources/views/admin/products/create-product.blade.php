@component('admin.layouts.content', [ 'title' => 'Products Panel'])

@slot('script')
    {{-- <script src="/static/js/ckeditor/ckeditor.js"></script> --}}

    <script>
        // CKEDITOR.replace( 'inputDescription' );
        CKEDITOR.replace('inputDescription', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});

        // attributes script
        function changeAttributeValues (event, id) {
            let valueBox = document.querySelector(`select[name='attributes[${id}][value]']`);
            const url = '/admin/attribute/values';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: event.target.value
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                valueBox.innerHTML = `
                    <option selected>انتخاب کنید</option>
                    ${data.data.map(item => `<option value="${item}">${item}</option>`).join('')}
                `;

                // Reinitialize select2 if needed
                document.querySelectorAll('.attribute-select').forEach(select => {
                    $(select).select2({ tags: true });
                });
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        };

        function createNewAttr ({attributes, id}) {
            return `
                <div class="row" id="attribute-${id}">
                    <div class="col-5">
                        <div class="form-group">
                            <label>عنوان ویژگی</label>
                            <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select form-control">
                                <option value="">انتخاب کنید</option>
                                ${ attributes.map( item => `<option value="${item}">${item}</option>`).join('') }
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label>مقدار ویژگی</label>
                            <select name="attributes[${id}][value]" class="attribute-select form-control">
                                <option value="">انتخاب کنید</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <label>اقدامات</label>
                        <div>
                            <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                        </div>
                    </div>
                </div>
            `;
        };

        document.getElementById('add_product_attribute').addEventListener('click', function() {
            let attributesSection = document.getElementById('attribute_section');
            let id = attributesSection.children.length;

            attributesSection.insertAdjacentHTML('beforeend', createNewAttr({
                attributes: [],
                id
            }));

            // Reinitialize select2 if needed
            document.querySelectorAll('.attribute-select').forEach(select => {
                $(select).select2({ tags: true });
            });
        });

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
<li class="breadcrumb-item active">Create Product</li>
<li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Create New Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputTitle" class="col-sm-2 control-label">Product Title</label>
                            <input id="inputTitle" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Add Product's Title">
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
                                <textarea class="form-control @error('description') is-invalid @enderror" id="inputDescription" rows="3" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Add Product's Description"></textarea>
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
                            <input type="number" id="inputInventory" class="form-control @error('inventory') is-invalid @enderror" name="inventory" value="{{ old('inventory') }}" required autocomplete="inventory" autofocus placeholder="Add Product's Inventory" />
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
                            <input type="number" id="inputPrice" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" placeholder="Add Product's Price"/>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 ">
                            <label class="control-label col-sm-2">Product Image</label>
                            {{-- <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" required/> --}}
                            <div class="input-group">
                                <input type="text" id="image_label" class="form-control" name="image">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" id="button-image">Select</button>
                                </div>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="category-product" class="col-sm-2 control-label">Add To</label>
                                <select name="categories[]" id="category-product" class="form-control" multiple>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{$category->id}}" >{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <h6>ویژگی محصول</h6>
                    <hr>
                    <div id="attribute_section"></div>
                    <button class="btn btn-sm btn-danger" type="button" id="add_product_attribute">ویژگی جدید</button>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Add Product</button>
                    <a href="{{route('admin.products.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
