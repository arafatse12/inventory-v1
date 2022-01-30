<div class="header navbar">
    <div class="header-container">
        <ul class="nav-left">
            <li>
            <a id='sidebar-toggle' class="sidebar-toggle" href="javascript:void(0);">
                <i class="ti-menu"></i>
            </a>
            </li>
            <li class="search-box">
            <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                <i class="search-icon ti-search pdd-right-10"></i>
                <i class="search-icon-close ti-close pdd-right-10"></i>
            </a>
            </li>
            <li class="search-input">
            <input class="form-control" type="text" placeholder="Search...">
            </li>
        </ul>

        <ul class="nav-right">
            <ul class="dropdown-menu">
                <li class="pX-20 pY-15 bdB">
                <i class="ti-email pR-10"></i>
                <span class="fsz-sm fw-600 c-grey-900">Emails</span>
                </li>
                <li>
                    <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                        <li>
                            <a href="" class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>
                            <div class="peer mR-15">
                            <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
                            </div>
                            <div class="peer peer-greed">
                            <div>
                                <div class="peers jc-sb fxw-nw mB-5">
                                <div class="peer">
                                    <p class="fw-500 mB-0">Lee Doe</p>
                                </div>
                                <div class="peer">
                                    <small class="fsz-xs">25 mins ago</small>
                                </div>
                                </div>
                                <span class="c-grey-600 fsz-sm">
                                Want to create your own customized data generator for your app...
                                </span>
                            </div>
                            </div>
                        </a>
                        </li>
                    </ul>
                </li>
                <li class="pX-20 pY-15 ta-c bdT">
                    <span>
                        <a href="email.html" class="c-grey-600 cH-blue fsz-sm td-n">View All Email <i class="fs-xs ti-angle-right mL-10"></i></a>
                    </span>
                </li>
            </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-bs-toggle="dropdown">
                    <div class="peer mR-10">
                        <img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                    </div>
                    <div class="peer">
                        <span class="fsz-sm c-grey-900">
                        {{ Auth::user()->name }}
                        </span>
                    </div>
                </a>
                <ul id="profile_dropdown" class="dropdown-menu fsz-sm">
                    <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-settings mR-10"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-user mR-10"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="email.html" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-email mR-10"></i>
                            <span>Messages</span>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="d-b td-n pY-5 bgcH-grey-100 c-grey-700" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="ti-power-off mR-10"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
