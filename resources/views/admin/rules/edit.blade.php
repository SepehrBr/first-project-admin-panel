@component('admin.layouts.content', [ 'title' => 'Rules Panel'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Edit Rule</li>
<li class="breadcrumb-item"><a href="/admin/users">Rules List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Rule</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.rules.update', ['rule' => $rule->id ])}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputName" class="col-sm-2 control-label">Rule Name</label>
                            <input id="inputName" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $rule->name) }}" required autocomplete="name" autofocus placeholder="Add Rule's Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputLabel" class="col-sm-2 control-label">Rule Decription</label>
                            <input id="inputLabel" type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $rule->label) }}" required autocomplete="label" placeholder="Add Rule's Decription">
                            @error('label')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Permissions</label>
                        <select name="permissions[]" id="" class="form-control" multiple="multiple">
                            @foreach (\App\Models\Permission::all() as $permission)
                                <option value="{{$permission->id}}" {{ in_array($permission->id, $rule->permissions->pluck('id')->toArray()) ? 'selected' : '' }} >{{$permission->name}} - {{$permission->label}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Edit</button>
                    <a href="{{route('admin.rules.index')}}" class="btn btn-default float-left">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endcomponent
