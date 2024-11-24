@component('admin.layouts.content', [ 'title' => 'Create Image'])

@slot('script')
    <script>
        function createNewPic ({id}) {
            return `
                <div class="row image-field" id="image-${id}">
                    <div class="col-5">
                        <div class="form-group">
                            <label>تصویر</label>
                            <div class="input-group">
                                <input type="text" class="form-control image_label" name="images[${id}][image]"
                                    aria-label="Image" aria-describedby="button-image">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary button-image" type="button">انتخاب</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label>عنوان تصویر</label>
                            <input type="text" name="images[${id}][alt]" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <label>اقدامات</label>
                        <div>
                            <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('image-${id}').remove()">حذف</button>
                        </div>
                    </div>
                </div>
            `;
        };

        document.getElementById('add_product_image').addEventListener('click', function() {

            let imagesSection = document.getElementById('images_section');
            let id = imagesSection.children.length;

            imagesSection.insertAdjacentHTML('beforeend', createNewPic({ id }));
        });

        document.getElementById('add_product_image').click();

        // input
        let image;
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('button-image')) {
                event.preventDefault();
                image = event.target.closest('.image-field');
                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            }
        });

        // set file link
        function fmSetLink(url) {
            image.querySelector('.image_label').value = url;
        }
    </script>
@endslot

@slot('breadcrumb')
<li class="breadcrumb-item active">{{ $product->title }}</li>
<li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Image</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ route('admin.products.gallery.store' , ['product' => $product->id]) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div id="images_section">
                    </div>
                    <button class="btn btn-sm btn-danger" type="button" id="add_product_image">New Image</button>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="{{ route('admin.products.gallery.index' , ['product' => $product->id]) }}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
