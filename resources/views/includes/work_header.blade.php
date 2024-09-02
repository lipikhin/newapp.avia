<div class="container-fluid ">
    <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb mt-2 float-sm-right">

                <li class="breadcrumb-item"><a href="#">Home</a></li>
                @auth
                    @if(Auth::user()->is_admin)
                        <li class="nav-item">
                            <div class="dropdown">
                              <a class="nav-link dropdown-toggle" id="dropdownMenuButton3" href="#"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{__('CMMs')}}
                                </a>
                                <ul class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item"
                                           href="{{route('admin.cmms.index')
                                           }}">{{__('CMMs')
                                        }}</a></li>
{{--                                    <li><a class="dropdown-item" href="{{route--}}
{{--                                       ('admin.cmms.create')}}">{{__(' Add CMM')}}</a></li>--}}
                                </ul>
                            </div>
                        </li>
                    @endif
                @endauth
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
