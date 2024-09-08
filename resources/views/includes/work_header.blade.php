<div class="container-fluid ">
    <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb mt-2 float-sm-right">

                <li class="breadcrumb-item">
                    <h3>
                        <a href="{{url('/home')
                }}">Home</a></li>
                    </h3>

                @auth
                    @if(Auth::user()->is_admin)

{{--                        <li class="nav-item">--}}
{{--                            <div class="dropdown">--}}
{{--                              <a class="nav-link dropdown-toggle" id="dropdownMenuButton3" href="#"--}}
{{--                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                    {{__('CMMs')}}--}}
{{--                                </a>--}}
{{--                                <ul class="dropdown-menu"--}}
{{--                                    aria-labelledby="dropdownMenuButton2">--}}
{{--                                    <li><a class="dropdown-item"--}}
{{--                                           href="{{route('admin.cmms.index')--}}
{{--                                           }}">{{__('CMMs')--}}
{{--                                        }}</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="{{route--}}
{{--                                       ('admin.cmms.create')}}">{{__(' Add CMM')}}</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </li>--}}

                        <li class="nav-item ms-2 me-2">
                            <h3>
                                <a href="{{route('admin.cmms.index')}}">CMM</a>
                            </h3>

                        </li>
                        <li class="nav-item">
                            <h3>
                                <a href="{{route('admin.users.index')}}">Users</a>
                            </h3>

                        </li>
                    @endif
                @endauth
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
