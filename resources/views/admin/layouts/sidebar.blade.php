<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="https://thumb2.jobinjacdn.com/dIzZ-00oUADO_Ngo6wQrhfwyFeg=/256x256/filters:strip_exif():format(jpeg)/https://mstorage2.jobinjacdn.com/other/js_avatar_image_blob/250758f8-5f0d-4c56-b028-24f73cba0665/1_main.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"> سپهر برنا  </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

            {{-- admin --}}
            <li class="nav-items">
                <a href="{{route('admin.')}}" class="nav-link {{ isActive('admin.') }}">
                    <i class="nav-icon fa fa-dashboard"></i>
                    <p>Admin Panel</p>
                </a>
            </li>

            {{-- users --}}
            @can('show-users')
            <li class="nav-item has-treeview {{ isActive(['admin.users.index', 'admin.users.create', 'admin.users.edit'], 'menu-open')  }}">
                <a href="#" class="nav-link {{ isActive(['admin.users.index', 'admin.users.create', 'admin.users.edit']) }}">
                  <i class="nav-icon fa fa-users"></i>
                  <p>
                    Users
                    <i class="right fa fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('admin.users.index')}}" class="nav-link  {{ isActive(['admin.users.index', 'admin.users.create', 'admin.users.edit']) }}">
                      <i class="fa fa-circle-o nav-icon"></i>
                      <p>Users List</p>
                    </a>
                  </li>
                </ul>
            </li>
            @endcan

            {{-- products --}}
            @can('show-products')
            <li class="nav-item has-treeview {{ isActive(['admin.products.index', 'admin.products.create', 'admin.products.edit'], 'menu-open')  }}">
                <a href="#" class="nav-link {{ isActive(['admin.products.index', 'admin.products.create', 'admin.products.edit']) }}">
                  <i class="nav-icon fa fa-product-hunt"></i>
                  <p>
                    Products
                    <i class="right fa fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('admin.products.index')}}" class="nav-link  {{ isActive(['admin.products.index', 'admin.products.create', 'admin.products.edit']) }}">
                      <i class="fa fa-circle-o nav-icon"></i>
                      <p>Products List</p>
                    </a>
                  </li>
                </ul>
            </li>
            @endcan


            {{-- comments --}}
            @can('show-comments')
            <li class="nav-item has-treeview {{  isActive(['admin.comments.index', 'admin.comments.unapproved'], 'menu-open')  }} ">
                <a href="#" class="nav-link {{isActive('admin.comments.index')  }}">
                  <i class="nav-icon fa fa-comment"></i>
                  <p>
                    Comments
                    <i class="right fa fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    {{-- @can('show-permissions') --}}
                      <li class="nav-item">
                          <a href="{{route('admin.comments.index')}}" class="nav-link  {{ isActive('admin.comments.index') }}">
                              <i class="fa fa-circle-o nav-icon"></i>
                              <p>Comments List</p>
                          </a>
                      </li>
                    {{-- @endcan --}}
                  </ul>
                  <ul class="nav nav-treeview">
                      {{-- @can('show-rules') --}}
                          <li class="nav-item">
                              <a href="{{ route('admin.comments.unapproved') }}" class="nav-link  {{ isActive('admin.comments.unapproved') }}">
                              <i class="fa fa-circle-o nav-icon"></i>
                              <p>Unapproved</p>
                              </a>
                          </li>
                      {{-- @endcan --}}
                  </ul>
              </li>
            @endcan


              {{-- categories --}}
            <li class="nav-item has-treeview {{ isActive(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit'], 'menu-open')  }} ">
              <a href="#" class="nav-link {{ isActive(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit']) }}">
                <i class="nav-icon fa fa-list-ul"></i>
                <p>
                  Category
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  @can('show-categories')
                    <li class="nav-item">
                        <a href="{{route('admin.categories.index')}}" class="nav-link  {{ isActive(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit']) }}">
                            <i class="fa fa-circle-o nav-icon"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                  @endcan
                </ul>


              {{-- auth --}}
            <li class="nav-item has-treeview {{ isActive(['admin.permissions.index', 'admin.permissions.create', 'admin.permissions.edit', 'admin.rules.index', 'admin.rules.create', 'admin.rules.edit'], 'menu-open')  }} ">
              <a href="#" class="nav-link {{ isActive(['admin.permissions.index', 'admin.permissions.create', 'admin.permissions.edit', 'admin.rules.index', 'admin.rules.create', 'admin.rules.edit']) }}">
                <i class="nav-icon fa fa-universal-access"></i>
                <p>
                  Authorize
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  @can('show-permissions')
                    <li class="nav-item">
                        <a href="{{route('admin.permissions.index')}}" class="nav-link  {{ isActive(['admin.permissions.index', 'admin.permissions.create', 'admin.permissions.edit']) }}">
                            <i class="fa fa-circle-o nav-icon"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                  @endcan
                </ul>
                <ul class="nav nav-treeview">
                    @can('show-rules')
                        <li class="nav-item">
                            <a href="{{route('admin.rules.index')}}" class="nav-link  {{ isActive(['admin.rules.index', 'admin.rules.create', 'admin.rules.edit']) }}">
                            <i class="fa fa-circle-o nav-icon"></i>
                            <p>Rules</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>


              {{-- modules --}}
            <li class="nav-item has-treeview {{ isActive(['admin.modules.index', 'admin.discount.index'], 'menu-open')  }} ">
                <a href="#" class="nav-link {{ isActive(['admin.modules.index', 'admin.discount.index']) }}">
                    <i class="nav-icon fa fa-list-alt"></i>
                    <p>
                    Modules
                    <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                  @can('show-modules')
                    @foreach (Module::collections() as $module)
                        @if (View::exists("{$module->getLowerName()}::admin.sidebar-{$module->getLowerName()}-module"))
                            @include("{$module->getLowerName()}::admin.sidebar-{$module->getLowerName()}-module")
                        @endif
                    @endforeach
                  @endcan
                </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>
