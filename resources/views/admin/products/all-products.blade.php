@component('admin.layouts.content', [ 'title' => 'Products'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Products List</li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
    <h2>Products List</h2>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Products Table</h3>
              <div class="card-tools d-flex">
                <form action="">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="search" value="{{request('search')}}">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                <div class="btn-group-sm mr-2">
                    @can('create-product')
                        <a href="{{ route('admin.products.create') }}" class="btn btn-info">Create New Product</a>
                    @endcan
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th></th>
                  <th>Product Title</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Inventory</th>
                  <th>View Count</th>
                  <th>Actions</th>
                </tr>
                @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->inventory}}</td>
                        <td>{{$product->view_count}}</td>
                        <td>
                            @can('delete-product')
                                <form action="{{route('admin.products.destroy', [ 'product' => $product->id ])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">DELETE</button>
                                </form>
                            @endcan
                            @can('edit-product')
                                <form action="{{route('admin.products.edit',  [ 'product' => $product->id  ])}}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-warning mt-2">EDIT</button>
                                </form>
                            @endcan
                            <a href="{{ route('admin.products.gallery.index', [ 'product' => $product->id]) }}" class="btn btn-primary mt-2">
                                Gallery
                            </a>
                        </td>
                    </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{ $products->appends([ 'search' => request('search')])->render() }}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
@endcomponent
