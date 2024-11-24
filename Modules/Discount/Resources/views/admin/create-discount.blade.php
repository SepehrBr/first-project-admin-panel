@component('admin.layouts.content' , ['title' => 'ایجاد کد تخفیف'])
    @slot('breadcrumb')
    <li class="breadcrumb-item active">ایجاد کد تخفیف</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">لیست تخفیف‌ها</a></li>
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
    @endslot

    @slot('script')
        <script>

            $('#users').select2({
                'placeholder' : 'محصول مورد نظر را انتخاب کنید'
            })

            $('#products').select2({
                'placeholder' : 'محصول مورد نظر را انتخاب کنید'
            })

            $('#categories').select2({
                'placeholder' : 'دسته مورد نظر را انتخاب کنید'
            })
        </script>
    @endslot

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد کد تخفیف</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.discount.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">کد تخفیف</label>
                            <input type="text" name="code" class="form-control  @error('code') is-invalid @enderror" id="inputEmail3" placeholder="کد تخفیف را وارد کنید" value="{{ old('code') }}">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="precent" class="col-sm-2 control-label">میزان تخفیف (درصد)</label>
                            <input type="number" name="percent" class="form-control @error('percent') is-invalid @enderror" placeholder="درصد تخفیف را وارد کنید" value="{{ old('percent') }}">
                            @error('percent')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">کاربر مربوط به تخفیف (اختیاری)</label>
                            <select class="form-control @error('users') is-invalid @enderror" name="users[]" id="users" multiple>
                                <option value="null">همه کاربرها</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('users')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">محصول مربوطه (اختیاری)</label>
                            <select class="form-control @error('products') is-invalid @enderror" name="products[]" id="products" multiple>
                                <option value="null">همه محصول</option>
                                @foreach(\App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                            @error('products')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">دسته‌بندی مربوطه (اختیاری)</label>
                            <select class="form-control @error('categories') is-invalid @enderror" name="categories[]" id="categories" multiple>
                                <option value="null">همه دسته‌ها</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">مهلت استفاده</label>
                            <input type="datetime-local" name="expired_at" class="form-control @error('expired_at') is-invalid @enderror" id="inputEmail3" placeholder="ملهت استفاده را وارد کنید" value="{{ old('expired_at') }}">
                            @error('expired_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت کد تخفیف</button>
                        <a href="{{ route('admin.discount.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
