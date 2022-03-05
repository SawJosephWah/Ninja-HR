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

    {{-- feather icon --}}
    <link href="{{ asset('/css/feather/feather.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

     <!-- Datatable -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

    {{-- date range picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- datatable responsive --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    {{-- select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- viewer.js css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.css" integrity="sha512-r+5gXtPk5M2lBWiI+/ITUncUNNO15gvjjVNVadv9qSd3/dsFZdpYuVu4O2yELRwSZcxlsPKOrMaC7Ug3+rbOXw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    @yield('custom_css')
</head>
<body>
    <div class="page-wrapper chiller-theme">
        <nav id="sidebar" class="sidebar-wrapper">
          <div class="sidebar-content">
            <div class="sidebar-brand">
              <a href="{{url('/')}}">ninja hr</a>
              <div id="close-sidebar">
                <i class="fas fa-times"></i>
              </div>
            </div>
            <div class="sidebar-header">
              <div class="user-pic">
                <img class="img-responsive img-rounded" src="{{asset('/img/profiles/'.auth()->user()->image)}}"
                  alt="User picture">
              </div>
              <div class="user-info">
                <span class="user-name">
                  <strong>{{auth()->user()->name}}</strong>
                </span>
                <span class="user-role">{{ auth()->user()->department ? auth()->user()->department->title : 'No Department'}}</span>
                <span class="user-status">
                  <i class="fa fa-circle"></i>
                  <span>Online</span>
                </span>
              </div>
            </div>
            <!-- sidebar-header  -->
            <div class="sidebar-menu">
              <ul>
                <li class="header-menu">
                  <span>Menu</span>
                </li>
                @can('view_profile')
                <li>
                    <a href="{{url('/')}}">
                      <i class="fas fa-home"></i>
                      <span>Home</span>
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
                      <i class="fas fa-sitemap"></i>
                      <span>Departments</span>
                    </a>
                </li>
                @endcan
                @can('view_permission')
                <li>
                    <a href="{{route('permission.index')}}">
                      <i class="fas fa-shield-alt"></i>
                      <span>Permissions</span>
                    </a>
                </li>
                @endcan
                @can('view_role')
                <li>
                    <a href="{{route('role.index')}}">
                      <i class="fas fa-user-shield"></i>
                      <span>Roles</span>
                    </a>
                </li>
                @endcan
                 @can('view_company_setting')
                <li>
                    <a href="{{route('company_setting.show',1)}}">
                      <i class="fas fa-landmark"></i>
                      <span>Company Setting</span>
                    </a>
                </li>
                @endcan

                <li>
                    <a href="{{route('projects.index')}}">
                      <i class="fas fa-toolbox"></i>
                      <span>Projects</span>
                    </a>
                </li>

                @can('view_attendance')
                <li>
                    <a href="{{route('attendance.index')}}">
                      <i class="fas fa-calendar-check"></i>
                      <span>Attendance</span>
                    </a>
                </li>
                @endcan



                @can('view_attendance')
                <li>
                    <a href="{{route('attendance.overview')}}">
                      <i class="fas fa-calendar-check"></i>
                      <span>Attendance Overview</span>
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

                <li>
                    <a href="{{route('payroll.index')}}">
                      <i class="fas fa-money-check"></i>
                      <span>Payroll</span>
                    </a>
                </li>



                {{-- <li class="sidebar-dropdown">
                  <a href="#">
                    <i class="fa fa-globe"></i>
                    <span>Maps</span>
                  </a>
                  <div class="sidebar-submenu">
                    <ul>
                      <li>
                        <a href="#">Google maps</a>
                      </li>
                      <li>
                        <a href="#">Open street map</a>
                      </li>
                    </ul>
                  </div>
                </li> --}}
              </ul>
            </div>
            <!-- sidebar-menu  -->
          </div>
          <!-- sidebar-content  -->
        </nav>
        <div class="top-menu">
            <div class="container">
                 <div class="d-flex justify-content-between">
                    @if (request()->is('/') )
                    <a id="show-sidebar"  class="d-flex justify-content-center align-items-center" >
                        <i class="fas fa-bars" style="font-size:25px"></i>
                    </a>
                    @else
                    <a id="back-btn" class="d-flex justify-content-center align-items-center" >
                        <i class="fas fa-arrow-left" style="font-size:25px"></i>
                    </a>
                    @endif

                    <h5>@yield('title')</h5>
                    <div class="d-flex justify-content-center align-items-center" >
                        <i class="fas fa-bell" style="font-size:25px"></i>
                    </div>
                 </div>
            </div>

        </div>
         <div style="padding: 100px 0">
             @yield('content')
         </div>

         <div class="bottom-menu">
             <div class="container">
                 <div class="d-flex justify-content-between">
                     <a href="{{route('home')}}">
                         <i class="fas fa-home"></i>
                         <p class="mb-0">home</p>
                     </a>
                     <a href="{{route('attendanceScan')}}">
                         <i class="fas fa-user-clock"></i>
                         <p class="mb-0">Attendance</p>
                     </a>
                     <a href="{{route('myproject')}}">
                         <i class="fas fa-briefcase"></i>
                         <p class="mb-0">My Projects</p>
                     </a>
                     <a href="{{route('profile')}}">
                         <i class="fas fa-user"></i>
                         <p class="mb-0">Profile</p>
                     </a>
                 </div>
             </div>
         </div>

      </div>
    <div id="app">

    </div>


    <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
<!-- datatables -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

{{-- date range picker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 <!-- Laravel Javascript Validation -->
 <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

 {{-- sweet alert --}}
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 {{-- sweet alert 1 --}}
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 {{-- datatable responsive --}}
 <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

 {{-- datatable mark js --}}
 <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>

{{-- select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- viewer.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.js" integrity="sha512-lzNiA4Ry7CjL8ewMGFZ5XD4wIVaUhvV3Ct9BeFmWmyq6MFc42AdOCUiuUtQgkrVVELHA1kT7xfSLoihwssusQw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- sortable js --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>


<script>
    jQuery(function ($) {
        //back history
        $(document).on("click","#back-btn",function(e) {
            e.preventDefault();
            window.history.go(-1);
        });

        //side bar
        $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }});

        $("#close-sidebar").click(function(e) {
            e.preventDefault();
            $(".page-wrapper").removeClass("toggled");
        });
        $("#show-sidebar").click(function(e) {
            e.preventDefault();
            $(".page-wrapper").addClass("toggled");
        });

        //sweet alert
        @if(Session::has('success'))
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        @endif

        @if(Session::has('error'))
            Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "{{session('error')}}",
            showConfirmButton: false,
            timer: 2000
            })
        @endif

        // datatable default setting
        $.extend(true, $.fn.dataTable.defaults, {
            mark: true,
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                    paginate: {
                        next: "<i class='fas fa-arrow-right'>",
                        previous: "<i class='fas fa-arrow-left'>"
                    },
                    processing:'loading'
                }
        });

        //select 2
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Select --",
                allowClear: true
            });

        });

        });
</script>

@yield('custom-script')
</body>
</html>
