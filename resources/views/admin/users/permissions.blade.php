@component('admin.layouts.content', [ 'title' => 'Users Panel'])

{{-- @slot('script')
    <script>
        $('#user_permission').select2({})
        $('#user_rule').select2({})
    </script>
@endslot --}}

@slot('breadcrumb')
<li class="breadcrumb-item active">Register Permission & Rule</li>
<li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Register Permission & Rule For User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.users.permissions.store', $user->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="user_permission" class="col-sm-2 control-label">Permissions</label>
                        <select name="permissions[]" id="user_permission" class="form-control" multiple>
                            @foreach (\App\Models\Permission::all() as $permission)
                                <option value="{{$permission->id}}" {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'selected' : '' }} >{{$permission->name}} - {{$permission->label}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_rule" class="col-sm-2 control-label">Rules</label>
                        <select name="rules[]" id="user_rule" class="form-control" multiple>
                            @foreach (\App\Models\Rule::all() as $rule)
                                <option value="{{$rule->id}}" {{ in_array($rule->id, $user->rules->pluck('id')->toArray()) ? 'selected' : '' }} >{{$rule->name}} - {{$rule->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <a href="{{route('admin.users.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
