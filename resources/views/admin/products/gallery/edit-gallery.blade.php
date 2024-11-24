@component('admin.layouts.content', [ 'title' => 'Edit Image'])

@slot('script')
    <script>
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
                <h3 class="card-title">Edit Image</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ route('admin.products.gallery.update' , ['product' => $product->id, 'gallery' => $gallery->id] ) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div id="images_section">
                        <div class="row image-field">
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <div class="input-group">
                                        <input type="text" name="image" id="" class="form-control image_label" value="{{ old('image', $gallery->image)}}" aria-label="Image" aria-describedby="button-image">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary button-image">Choose Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="">Alt</label>
                                    <input type="text" name="alt" class="form-control" value="{{ old('image', $gallery->alt)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Edit</button>
                    <a href="{{ route('admin.products.gallery.index' , ['product' => $product->id]) }}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
