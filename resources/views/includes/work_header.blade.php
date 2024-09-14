<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ul class="breadcrumb mt-2  ">

                <li class="nav-item ">
                    <h3>
                        <a href="{{url('/home')}}" class="btn btn-primary">Home</a>
                    </h3>
                </li>
                <li class="nav-item ms-2">
                    <h3>
                        <a href="{{route('user.trainings.index')
                        }}" class="btn btn-primary"> Training </a>
                    </h3>

                </li>



                @auth
                    @if(Auth::user()->is_admin)

                        <li class="nav-item ms-2">
                            <h3>
                                <a href="{{route('admin.cmms.index')}}" class="btn btn-primary">CMM</a>
                            </h3>

                        </li>
                        <li class="nav-item ms-2">
                            <h3>
                                <a href="{{route('admin.users.index')}}" class="btn btn-primary"
                                >Users</a>
                            </h3>

                        </li>
                        <li class="nav-item ms-2">
                            <h3>
                                <a href="{{route('admin.customers.index')}}" class="btn btn-primary"
                                >Customers</a>
                            </h3>

                        </li>
                    @endif
                @endauth
            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
