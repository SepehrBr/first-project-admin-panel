@component('admin.layouts.content', [ 'title' => 'Categories Panel'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Create Category</li>
<li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Categories List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Create New Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.categories.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputName" class="col-sm-2 control-label">Category Name</label>
                            <input id="inputName" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Add Category's Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if (request('parent'))
                    @php
                        $parent = \App\Models\Category::find(request('parent'));
                    @endphp
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputParent" class="col-sm-2 control-label">Parent Category</label>
                            <input id="inputParent" type="text" class="form-control" name="name" value="{{ $parent->name }}" disabled >
                            <input type="hidden" name="parent" value="{{ $parent->id }}">
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="category-product" class="col-sm-2 control-label">Add To</label>
                                <select name="parent[]" id="category-product" class="form-control" multiple>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="category_product" class="col-sm-2 control-label">Add To</label>
                                <select name="parent[]" id="category_product" class="form-control" multiple>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{$category->id}}" {{ in_array($category->id, $category->products->pluck('id')->toArray()) ? 'selected' : '' }} >{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Add Category</button>
                    <a href="{{route('admin.categories.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
