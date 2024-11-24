@component('admin.layouts.content', [ 'title' => 'Categories Panel'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Edit Category</li>
<li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Categories List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.categories.update', [ 'category' => $category->id ])}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputName" class="col-sm-2 control-label">Category Name</label>
                            <input id="inputName" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}" required autocomplete="name" autofocus placeholder="Add Category's Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">Add To</label>
                                <select name="parent[]" id="category" class="form-control" multiple>
                                    @foreach (\App\Models\Category::all() as $cate)
                                        <option value="{{$cate->id}}" {{ ($category->parent == $cate->id) ? 'selected' : ''}}>{{$cate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Edit Category</button>
                    <a href="{{route('admin.categories.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
