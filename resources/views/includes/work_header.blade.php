<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ul class="breadcrumb mt-2  ">

                <li class="nav-item ">
                    <h3>
                        <a href="{{url('/home')}}">Home</a>
                    </h3>
                </li>
                @auth
                    @if(Auth::user()->is_admin)

                        <li class="nav-item ms-2">
                            <h3>
                                <a href="{{route('admin.cmms.index')}}">CMM</a>
                            </h3>

                        </li>
                        <li class="nav-item ms-2">
                            <h3>
                                <a href="{{route('admin.users.index')}}">Users</a>
                            </h3>

                        </li>
                        <li class="nav-item ms-2">
                            <h3>
                                <a href="{{route('admin.customers.index')}}">Customers</a>
                            </h3>

                        </li>
                    @endif
                @endauth
            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
