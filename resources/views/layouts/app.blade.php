<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    {{-- --Datatable --}}
    <link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    {{-- --Date Range Picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- ---Select 2--- --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    {{-- Viewer.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    @yield('extr.css')
</head>

<body>
    <div class="page-wrapper chiller-theme">

        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="#">NinJa HR</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="{{auth()->user()->employee_img_path()}}"
                            alt="User picture">
                    </div>
                    <div class="user-info">
                        <span class="user-name">
                            {{auth()->user()->name}}
                        </span>
                        <span class="user-role">{{auth()->user()->department ? auth()->user()->department->title :
                            '-'}}</span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Menu</span>
                        </li>

                        <li>
                            <a href="{{url('/')}}">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        @can('view_company_setting')
                        <li>
                            <a href="{{route('company-setting.show',1)}}">
                                <i class="fas fa-building"></i>
                                <span>Compay Setting</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_employee')
                        <li>
                            <a href="{{route('employee.index')}}">
                                <i class="fas fa-users"></i>
                                <span>Employees</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_department')
                        <li>
                            <a href="{{route('department.index')}}">
                                <i class="fas fa-balance-scale"></i>
                                <span>Department</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_role')
                        <li>
                            <a href="{{route('role.index')}}">
                                <i class="fas fa-user-shield"></i>
                                <span>Role</span>
                            </a>
                        </li>
                        @endcan



                        @can('view_permission')
                        <li>
                            <a href="{{route('permission.index')}}">
                                <i class="fas fa-shield-alt"></i>
                                <span>Permission</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_salary')
                        <li>
                            <a href="{{route('salary.index')}}">
                                <i class="fas fa-money-bill"></i>
                                <span>Salary</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_attendance')
                        <li>
                            <a href="{{route('attendance.index')}}">
                                <i class="fas fa-shield-alt"></i>
                                <span>Attendance(Employee)</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_attendance_overview')
                        <li>
                            <a href="{{route('attendance-overview')}}">
                                <i class="fas fa-shield-alt"></i>
                                <span>Attendance(Overview)</span>
                            </a>
                        </li>
                        @endcan
                        @can('view_payroll')
                        <li>
                            <a href="{{route('payroll')}}">
                                <i class="fas fa-money-check"></i>
                                <span>PayRoll</span>
                            </a>
                        </li>
                        @endcan

                        @can('view_project')
                        <li>
                            <a href="{{route('project.index')}}">
                                <i class="fas fa-user-shield"></i>
                                <span>Project Management</span>
                            </a>
                        </li>
                        @endcan

                        {{-- <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="far fa-gem"></i>
                                <span>Components</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">General</a>
                                    </li>
                                    <li>
                                        <a href="#">Panels</a>
                                    </li>
                                    <li>
                                        <a href="#">Tables</a>
                                    </li>
                                    <li>
                                        <a href="#">Icons</a>
                                    </li>
                                    <li>
                                        <a href="#">Forms</a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}


                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
            <div class="sidebar-footer">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-warning notification">3</span>
                </a>
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span class="badge badge-pill badge-success notification">7</span>
                </a>
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span class="badge-sonar"></span>
                </a>
                <a href="#">
                    <i class="fa fa-power-off"></i>
                </a>
            </div>
        </nav>

        <div class="header_menu">
            <div class="d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="d-flex justify-content-between">

                        @if(request()->is('/'))
                        <a href="#" id="show-sidebar">
                            <i class="fas fa-bars"></i>
                        </a>
                        @else
                        <a href="#" id="back_btn">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                        @endif

                        <h5>@yield('title')</h5>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-4 content">
            <div class="d-flex justify-content-center">
                <div class="col-md-10">
                    @yield('content')
                </div>
            </div>
        </div>

        <div class="bottom_menu">
            <div class="d-flex justify-content-center">
                <div class="col-md-10 ">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>
                            <p class="mb-0">Home</p>
                        </a>
                        <a href="{{route('attendance-scan')}}">
                            <i class="fas fa-user-clock"></i>
                            <p class="mb-0">Attendance</p>

                        </a>
                        <a href="{{route('my-project.index')}}">
                            <i class="fas fa-briefcase"></i>
                            <p class="mb-0">Project</p>

                        </a>
                        <a href="{{route('profile.profile')}}">
                            <i class="fas fa-user"></i>
                            <p class="mb-0">Profile</p>

                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js">
    </script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>

    {{-- -------Datatable---- --}}
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
    {{-- -------DateRange Picker --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- ---Select 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('vendor/larapass/js/larapass.js') }}"></script>
    {{-- Viewer Js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.js"></script>

    <script>
    $(document).ready(function(){
        $('.role_box').select2({
            theme: 'bootstrap4',

        });

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#back_btn').on('click',function(e){
                e.preventDefault();
                window.history.go(-1);
                return false;
            });

        });

    $(function ($) {

        $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
            ){

            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");

            } else{
                $(".sidebar-dropdown").removeClass("active");
                $(this).next(".sidebar-submenu").slideDown(200);
                $(this).parent().addClass("active");

                }
                });

            $("#close-sidebar").click(function() {
            $(".page-wrapper").removeClass("toggled");
            });

            $("#show-sidebar").click(function() {
            $(".page-wrapper").addClass("toggled");

            });

            @if(request()->is('/'))
            document.addEventListener('click',function(event){

                if(document.getElementById('show-sidebar').contains(event.target)){
                $(".page-wrapper").addClass("toggled");

                }else if(!document.getElementById('sidebar').contains(event.target)){
                    $(".page-wrapper").removeClass("toggled");

                }
            });
            @endif

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                @if(session('create'))
                Toast.fire({
                icon: 'success',
                title: "{{session('create')}}",
                })
                @endif

                @if(session('update'))
                Toast.fire({
                icon: 'success',
                title: "{{session('update')}}",
                })
                @endif

                $.extend(true, $.fn.dataTable.defaults, {
                    mark: true
                });




     });







    </script>

    @yield('scripts')
</body>

</html>
