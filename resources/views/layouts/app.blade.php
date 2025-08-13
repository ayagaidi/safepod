<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- logo.ico --}}
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('logo.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>safePod-@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('dash/assets/styles/style.min.css') }}">

    <!-- Material Design Icon -->
    <link rel="stylesheet" href="{{ asset('dash/assets/fonts/material-design/css/materialdesignicons.css') }}">

    <!-- mCustomScrollbar -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}">

    <!-- Waves Effect -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/waves/waves.min.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/iCheck/skins/square/blue.css') }}">

    <!-- RTL -->
    <link rel="stylesheet" href="{{ asset('dash/assets/styles/style-rtl.min.css') }}">
    <!-- cairo -->

    <link rel="stylesheet" href="{{ asset('dash/assets/fonts/cairo.css') }}">



    <script src="{{ asset('dash/assets/scripts/jquery.min.js') }}"></script>
    <script src="{{ asset('dash/assets/scripts/modernizr.min.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/bootstrap/js/bootstrap.min.js') }}"></script>


    <script src="{{ asset('dash/assets/jquery-datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('dash/assets/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>

    <script src="{{ asset('dash/assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- <script src="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.min.js') }}"></script> -->
    <script src="{{ asset('dash/assets/plugin/waves/waves.min.js') }}"></script>
    <!-- Full Screen Plugin -->
    <script src="{{ asset('dash/assets/plugin/fullscreen/jquery.fullscreen-min.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('sweetalert2@9') }}"></script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .dataTables_wrapper .dt-buttons {
            float: none;
            text-align: left;
        }

        .dataTables_wrapper .dataTables_filter {
            text-align: right;
            float: right;
        }
    </style>

    <script>
        function fetchNotifications() {
            $.ajax({
                url: "{{ route('notifications.fetch') }}", // Fetch notifications dynamically
                method: "GET",
                success: function(data) {
                    // Update unread count badge
                    const badge = $('.ico-item .badge');
                    if (data.unreadCount > 0) {
                        badge.text(data.unreadCount).show();
                    } else {
                        badge.hide();
                    }

                    // Update notifications list
                    let notificationsList = '';
                    data.notifications.forEach(notification => {
                        notificationsList += `
                            <li>
                                <a style="width: 100%" class="dropdown-item d-flex align-items-start ${notification.is_read ? '' : 'font-weight-bold'}" 
                                   href="${notification.readUrl}">
                                    <div class="mr-3">
                                        <i class="fa fa-bell text-primary"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>${notification.message}</span>
                                        </div>
                                        <small class="text-muted d-block">${notification.timeAgo}</small>
                                    </div>
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                        `;
                    });

                    $('.sub-ico-item > div').html(notificationsList ||
                        '<li class="dropdown-item text-muted text-center">لا توجد إشعارات جديدة</li>');
                },
                error: function() {
                    console.error('Failed to fetch notifications.');
                }
            });
        }

        // Fetch notifications every 1 second
        setInterval(fetchNotifications, 1000);
    </script>

</head>

<body style="font-family:Cairo;">

    <div class="main-menu">
        <header class="header">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('mlogo.png') }}" alt="" style="max-width: 20% !important;">

            </a>
            <button type="button" class="button-close fa fa-times js__menu_close"></button>
        </header>
        <!-- /.header -->
        <div class="content">

            <div class="navigation">
                <ul class="menu js__accordion">
                    <li class="{{ Request::is('home*') ? 'current' : '' }} ">

                        <a class="waves-effect" href="{{ route('home') }}"><i
                                class="menu-icon mdi mdi-view-dashboard"></i><span>الرئيسية</span></a>
                    </li>
                    <li class="{{ Request::is('users*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('users') }}"><i
                                class="menu-icon fa fa-users"></i><span>{{ trans('app.users') }}</span></a>
                    </li>

                    <li class="{{ Request::is('cities*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('cities') }}"><i
                                class="menu-icon fa  fa-map-marker"></i><span>{{ trans('app.city') }}</span></a>
                    </li>
                    <li class="{{ Request::is('categories*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('categories.index') }}"><i
                                class="menu-icon fa  fa-list"></i><span>التصنيفات</span></a>
                    </li>
                    <li class="{{ Request::is('products*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('products') }}"><i
                                class="menu-icon fa  fa-list-alt"></i><span>المنتجات</span></a>
                    </li>

                    <li class="{{ Request::is('discounts*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('discounts') }}"><i
                                class="menu-icon fa fa-percent"></i><span>التخفيضات</span></a>
                    </li>

                    <li class="{{ Request::is('stock*') ? 'current' : '' }}">
                        <a class="waves-effect" href="{{ route('stock') }}">
                            <i class="menu-icon fa fa-square"></i><span>إدارة المخزون</span>
                        </a>
                    </li>

                    <li
                        class="{{ Request::is('pending/order') ? 'active' : '' }}|| {{ Request::is('cancel/order') ? 'active' : '' }}">
                        <a class="waves-effect parent-item js__control" href="#">
                            <i class="menu-icon fa fa-tasks"></i><span>إدارة الطلبات</span>
                            <span class="menu-arrow fa fa-angle-down"></span>
                        </a>
                        <ul class="sub-menu js__content">
                                                        <li><a href="{{ route('all/oreder') }}"> كافة الطلبات</a></li>

                            <li><a href="{{ route('pending/oreder') }}">قيد الانتظار </a></li>
                            <li><a href="{{ route('underprocess/oreder') }}">قيد التجهيز</a></li>
                            <li><a href="{{ route('complete/oreder') }}">مكتمل</a></li>
                            <li><a href="{{ route('cancel/oreder') }}">ملغي</a></li>

                        </ul>
                    </li>
                    <li class="{{ Request::is('receipts*') ? 'current' : '' }}">
                        <a class="waves-effect" href="{{ route('receipts') }}">
                            <i class="menu-icon fa fa-file-text"></i><span>إدارة اذن الاستلام</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('exchange*') ? 'current' : '' }} ">
                        <a class="waves-effect}}" href="{{ route('exchange') }}">
                            <i class="menu-icon fa fa-file"></i><span>إدارة المبيعات</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('returns*') ? 'current' : '' }} ">
                        <a class="waves-effect}}" href="{{ route('returns') }}">
                            <i class="menu-icon fa fa-file"></i><span>إدارة الرواجع</span>
                        </a>
                    </li>

                    <li
                        class="{{ Request::is('report/sales') ? 'active' : '' }}|| {{ Request::is('cancel/order') ? 'active' : '' }}">
                        <a class="waves-effect parent-item js__control" href="#">
                            <i class="menu-icon fa fa-folder-open-o"></i><span>إدارة التقارير</span>
                            <span class="menu-arrow fa fa-angle-down"></span>
                        </a>
                        <ul class="sub-menu js__content">
                            <li><a href="{{ route('report/sales') }}">المبيعات </a></li>
                            <li><a href="{{ route('report/return') }}">الرواجع </a></li>


                        </ul>
                    </li>

                    <li
                        class="{{ Request::is('slider*') || Request::is('salesbanners') || Request::is('aboutus') || Request::is('sitesetting') || Request::is('contactus') ? 'current' : '' }}">
                        <a class="waves-effect parent-item js__control" href="#"><i
                                class="menu-icon fa fa-wrench"></i><span> اعدادات الموقع </span><span
                                class="menu-arrow fa fa-angle-down"></span></a>
                        <ul class="sub-menu js__content" style="display: none;">
                            <li class=""><a href="{{ route('slider') }}">Slider </a></li>
                            <li class=""><a href="{{ route('salesbanners') }}">اعلان التخفيض </a></li>
                            <li class=""><a href="{{ route('aboutus') }}"> {{ trans('aboutus.aboutus') }} </a>
                            </li>
                            <li class=""><a href="{{ route('contactus') }}">اتصال بنا </a></li>

                        </ul>
                    </li>
                    <li class="{{ Request::is('policy*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('policy.index') }}"><i
                                class="menu-icon fa fa-info"></i><span>سياسات الموقع</span></a>
                    </li>



                    <li class="{{ Request::is('inbox*') ? 'current' : '' }} ">
                        <a class="waves-effect " href="{{ route('inbox') }}"><i class="menu-icon fa fa-envelope"></i><span> البريد</span></a>
                    </li>
                    <!-- Separator for logout -->
                    <li class="logout-item" style="border-top: 1px solid #ddd; margin-top: 10px;">
                        <a href="{{ route('logout') }}" class="waves-effect"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> {{ trans('app.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
                <!-- /.menu js__accordion -->
            </div>
            <!-- /.navigation -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.main-menu -->

    <div class="fixed-navbar">
        <div class="pull-left">
            <button type="button"
                class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
            <h1 class="page-title">@yield('title')</h1>
            <!-- /.page-title -->
        </div>
        <!-- /.pull-left -->
        <div class="pull-right">
            <!-- Notification Icon -->
            <div class="ico-item">
                <a href="#" class="ico-item">
                    <i class="fa fa-bell"></i>
                    @php
                        $unreadNotifications = \App\Models\Notification::where('is_read', false)->count();
                        $latestNotifications = \App\Models\Notification::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    @if ($unreadNotifications > 0)
                        <span class="badge badge-danger"
                            style="background-color: red; position: absolute; top: 5px; right: 5px;">{{ $unreadNotifications }}</span>
                    @endif
                </a>
                <ul class="sub-ico-item" style="width: 350px;">
                    <div class="dropdown-divider"></div>
                    <div style="max-height: 100%; overflow-y: auto;">
                        @forelse($latestNotifications as $notification)
                            <li>
                                <a style="width: 100%"
                                    class="dropdown-item d-flex align-items-start {{ $notification->is_read ? '' : 'font-weight-bold' }}"
                                    href="{{ route('notifications.read', $notification->id) }}">
                                    <div class="mr-3">
                                        <i class="fa fa-bell text-primary"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <small
                                            class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                        @empty
                            <li class="dropdown-item text-muted text-center">لا توجد إشعارات جديدة</li>
                        @endforelse
                    </div>
                    <li class="dropdown-item text-center text-primary font-weight-bold">
                        <a href="{{ route('notifications.index') }}">عرض جميع الإشعارات</a>
                    </li>

                </ul>
                <!-- /.sub-ico-item -->
            </div>
            <!-- /.ico-item -->
            <!-- /.ico-item fa fa-arrows-alt -->
            <div class="ico-item fa fa-arrows-alt js__full_screen"></div>
            <!-- /.ico-item -->

            <a href="#" class="ico-item ">
                <h5 class="name">{{ Auth::user()->username }}</h5>
            </a>
            <div class="ico-item">
                <img src="{{ asset('admin.png') }}" alt="" class="ico-img">
                <ul class="sub-ico-item">
                    <li><a href="{{ route('users/profile', encrypt(Auth::user()->id)) }}"><i class="fa fa-user"></i>
                            {{ trans('app.Profile') }}</a></li>

                    <li><a href="{{ route('users/ChangePasswordForm', encrypt(Auth::user()->id)) }}"><i
                                class="fa fa-lock"></i>{{ trans('app.changepassword') }} </a></li>
                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i
                                class="fa fa-sign-out"></i>
                            {{ trans('app.logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>>
                    </li>
                </ul>
                <!-- /.sub-ico-item -->
            </div>
            <!-- /.ico-item -->
        </div>
        <!-- /.pull-right -->
    </div>
    <!-- /.fixed-navbar -->

    <!-- /.content -->


    <div id="wrapper">
        <div class="main-content">
            @yield('content')
            @include('sweetalert::alert')

            <!-- /.row -->
            <footer class="footer">
                <ul class="list-inline">
                    <li><?php echo date('Y'); ?> &copy;{{ trans('login.copyright') }} </li>

                </ul>
            </footer>
        </div>
        <!-- /.main-content -->
    </div>


    <script src="{{ asset('dash/assets/scripts/main.min.js') }}"></script>

</body>

</html>
