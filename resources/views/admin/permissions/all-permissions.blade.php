@component('admin.layouts.content', [ 'title' => 'Permissions'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Permissions List</li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
    <h2>Permissions List</h2>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Permissions Table</h3>


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
                    @can('create-permission')
                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-info">Create New Permission</a>
                    @endcan
                    {{-- <a href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}" class="btn {{request('admin') ? 'btn-warning' : 'btn-outline-warning'}}">Admin Users</a>
                    <a href="{{ request()->fullUrlWithQuery(['staff' => 1]) }}" class="btn {{request('staff') ? 'btn-primary' : 'btn-outline-primary'}} ">Staff Users</a> --}}
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th></th>
                  <th>Permission Name</th>
                  <th>Desctiption</th>
                  <th>Actions</th>
                </tr>

                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->label}}</td>
                        <td>
                            @can('delete-permission')
                                <form action="{{route('admin.permissions.destroy', [ 'permission' => $permission->id ])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">DELETE</button>
                                </form>
                            @endcan
                            @can('edit-permission')
                                <form action="{{route('admin.permissions.edit',  [ 'permission' => $permission->id  ])}}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-warning mt-2">EDIT</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{ $permissions->appends([ 'search' => request('search')])->render() }}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
@endcomponent
