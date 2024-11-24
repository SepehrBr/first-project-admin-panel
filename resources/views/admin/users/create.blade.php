@component('admin.layouts.content', [ 'title' => 'Create New User Panel'])

@slot('breadcrumb')
<li class="breadcrumb-item active">Create User</li>
<li class="breadcrumb-item"><a href="/admin/users">Users List</a></li>
<li class="breadcrumb-item"><a href="/admin">Admin Dashborad</a></li>
@endslot
<div class="row">
    <div class="col-md-8">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Create New User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.users.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputName" class="col-sm-2 control-label">Name</label>
                            <input id="inputName" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Add Your Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                            <input id="inputEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@gmail.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                            <input id="inputPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="*********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="inputConfirmPassword" class="col-sm-2 control-label">Password Confirmation</label>
                            <input id="inputConfirmPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="*********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <label for="verify" class="form-check-label">
                            <input type="checkbox" name="verify" id="verify" class="form-check-input">
                            Activate Email
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label for="is_admin" class="form-check-label">
                            <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input">
                            Admin
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label for="is_staff" class="form-check-label">
                            <input type="checkbox" name="is_staff" id="is_staff" class="form-check-input">
                            Staff
                        </label>
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
