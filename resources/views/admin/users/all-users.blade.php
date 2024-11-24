@component('admin.layouts.content', [ 'title' => 'All Users List'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Users List</li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
    <h2>Users List</h2>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>


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
                    @can('create-user')
                     <a href="{{ route('admin.users.create') }}" class="btn btn-info">Create New User</a>
                    @endcan
                    @can('show-staff-users')
                        <a href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}" class="btn {{request('admin') ? 'btn-warning' : 'btn-outline-warning'}}">Admin Users</a>
                        <a href="{{ request()->fullUrlWithQuery(['staff' => 1]) }}" class="btn {{request('staff') ? 'btn-primary' : 'btn-outline-primary'}} ">Staff Users</a>
                    @endcan
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th>User ID</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Email Activation</th>
                  <th>Admin</th>
                  <th>Staff</th>
                  <th>Actions</th>
                </tr>

                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>

                        @if ($user->email_verified_at)
                            <td><span class="badge badge-success">verified</span></td>
                        @else
                            <td><span class="badge badge-danger">not verified</span></td>
                        @endif

                        @if ($user->is_superuser)
                            <td><span class="badge badge-success">Yes</span></td>
                        @else
                            <td><span class="badge badge-danger">No</span></td>
                        @endif

                        @if ($user->is_staff)
                            <td><span class="badge badge-success">Yes</span></td>
                        @else
                            <td><span class="badge badge-danger">No</span></td>
                        @endif

                    <td>
                        @can('delete-user')
                            <form action="{{route('admin.users.destroy', [ 'user' => $user->id ])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-2">DELETE</button>
                            </form>
                        @endcan
                        @can('edit-user')
                            <form action="{{route('admin.users.edit', [ 'user' => $user->id ])}}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-warning mt-2">EDIT</button>
                            </form>
                        @endcan
                        @can('staff-users-permission')
                            <a href="{{ route('admin.users.permissions', [ 'user' => $user->id ]) }}" type="submit" class="btn btn-primary mt-2">Permissions</a>
                        @endcan
                    </td>
                    </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{ $users->appends([ 'search' => request('search')])->render() }}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
@endcomponent
