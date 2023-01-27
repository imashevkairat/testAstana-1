<div class="header @@classList">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#"><i
                data-feather="menu"

                class="nav-icon me-2 icon-xs"></i></a>
        <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
{{--            <form class="d-flex align-items-center">--}}
{{--                <input type="search" class="form-control" placeholder="Search" />--}}
{{--            </form>--}}
        </div>
        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            <!-- profile -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src="{{url('admin/assets/images/avatar/avatar-1.jpg')}}"
                             class="rounded-circle" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end"
                     aria-labelledby="dropdownUser">
                    <div class="px-4 pb-0 pt-2">


                        <div class="lh-1 ">
                            <h5 class="mb-1"> {{auth()->user()->name}}</h5>
                            <a  class="text-inherit fs-6">{{auth()->user()->email}}</a>
                        </div>
                        <div class=" dropdown-divider mt-3 mb-2"></div>
                    </div>

                    <ul class="list-unstyled">
                        <li>
                            <a class="dropdown-item" href="{{route('profile.edit')}}">
                               Edit Profile
                            </a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{route('logout')}}"
                                   onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Выйти') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>
