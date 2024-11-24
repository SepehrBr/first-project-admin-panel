@component('admin.layouts.content', [ 'title' => 'Rules'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Rules List</li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
    <h2>Rules List</h2>
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Rules Table</h3>


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
                    @can('create-rule')
                        <a href="{{ route('admin.rules.create') }}" class="btn btn-info">Create New Rule</a>
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
                  <th>Rule Name</th>
                  <th>Desctiption</th>
                  <th>Actions</th>
                </tr>

                @foreach ($rules as $rule)
                    <tr>
                        <td>{{$rule->id}}</td>
                        <td>{{$rule->name}}</td>
                        <td>{{$rule->label}}</td>
                        <td>
                            @can('delete-rule')
                                <form action="{{route('admin.rules.destroy', [ 'rule' => $rule->id ])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">DELETE</button>
                                </form>
                            @endcan
                            @can('edit-rule')
                                <form action="{{route('admin.rules.edit',  [ 'rule' => $rule->id  ])}}" method="GET">
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
                {{ $rules->appends([ 'search' => request('search')])->render() }}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
@endcomponent
