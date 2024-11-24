@component('admin.layouts.content', [ 'title' => "Product's Gallery"])

@slot('breadcrumb')
<li class="breadcrumb-item active">{{ $product->title }}</li>
<li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gallery</h3>
                <div class="card-tools d-flex">
                    <div class="btn-group-sm mr-1">
                        <a href="{{ route('admin.products.gallery.create', ['product' => $product->id]) }}" class="btn btn-info">Add New Image</a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    @foreach ($images as $image)
                        <div class="col-sm-2">
                            <a href="{{ url($image->image) }}">
                                <img src="{{ url($image->image)}}" alt="{{ url($image->alt)}}" class="img-fluid mb-2">
                            </a>
                            <form action="{{ route('admin.products.gallery.destroy', ['product' => $product->id, 'gallery' => $image->id ]) }}" method="post" id="image-{{$image->id}}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a href="{{ route('admin.products.gallery.edit' , ['product' => $product->id, 'gallery' => $image->id ])}}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="document.getElementById('image-{{$image->id}}').submit()">Delete</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{ $images->appends([ 'search' => request('search')])->render() }}
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
      </div>
@endcomponent
