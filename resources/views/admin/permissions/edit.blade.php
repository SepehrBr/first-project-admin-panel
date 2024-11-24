@component('admin.layouts.content', [ 'title' => 'Permission Panel'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Edit Permission</li>
<li class="breadcrumb-item"><a href="/admin/users">Permissions List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Permission</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.permissions.update', ['permission' => $permission->id ])}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputName" class="col-sm-2 control-label">Permission Name</label>
                            <input id="inputName" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $permission->name) }}" required autocomplete="name" autofocus placeholder="Add Permission's Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputLabel" class="col-sm-2 control-label">Permission Decription</label>
                            <input id="inputLabel" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $permission->label) }}" required autocomplete="label" placeholder="Add Permission's Decription">
                            @error('label')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Edit</button>
                    <a href="{{route('admin.permissions.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
