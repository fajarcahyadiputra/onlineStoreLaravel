
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="this is aplikasi online store">
  <!--  <link href="img/logo/logo.png" rel="icon"> -->
  <title>@yield('title')</title>
  <!-- jquery -->
  <script src="{{URL::asset('admin/ruangAdmin/vendor/jquery/jquery.min.js')}}"></script>
  <!-- fontawesome -->
  <link href="{{URL::asset('admin/ruangAdmin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{URL::asset('admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <!-- ruangadmin -->
  <link href="{{URL::asset('admin/ruangAdmin/css/ruang-admin.min.css')}}" rel="stylesheet">
  <!-- datatable -->
  <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/datatable/css/jquery.dataTables.css')}}" />
  <link rel="stylesheet" href="{{URL::asset('admin/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- select2 -->
  <link rel="stylesheet" href="{{URL::asset('admin/select2/css/select2-bootstrap4.css')}}">
  <link href="{{URL::asset('admin/select2/css/select2.min.css')}}" rel="stylesheet" />
</head>

<body id="page-top">

  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
         <img class="around-circle" width="60" src="" alt="">
       </div>
       <div class="sidebar-brand-text mx-3">POS</div>
     </a>
     <li class="nav-item p-2" style="font-size: 15px">
      <center><b>Administrator</b></center>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item active">
      <a class="nav-link" href="/dashboardAdmin">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
      </li>

      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
        aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="far fa-fw fa-window-maximize"></i>
        <span>Data Master</span>
      </a>
      <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Data Master</h6>
          <a class="collapse-item" href="{{route('master.category')}}">Category</a>
          <a class="collapse-item" href="{{route('product.index')}}">Product</a>
          <a class="collapse-item" href="dropdowns.html">Dropdowns</a>
          <a class="collapse-item" href="modals.html">Modals</a>
          <a class="collapse-item" href="popovers.html">Popovers</a>
          <a class="collapse-item" href="progress-bar.html">Progress Bars</a>
        </div>
      </div>
    </li>
    <hr class="sidebar-divider">

    <li class="nav-item">
      <a class="nav-link" href="">
       <i class="fas fa-tasks"></i>
       <span>Data Barang</span></a>
     </li>
     <hr class="sidebar-divider">

     <li class="nav-item">
      <a class="nav-link" href="">
       <i class="fas fa-tasks"></i>
       <span>Barang Keluar</span></a>
     </li>
     <hr class="sidebar-divider">

     <hr class="sidebar-divider">


     <div class="version" id="version-ruangadmin"></div>
   </ul>
   <!-- Sidebar -->
   <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      <!-- TopBar -->
      <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
              <form class="navbar-search">
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li>



          <div class="topbar-divider d-none d-sm-block"></div>
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="img-profile rounded-circle" src="" style="max-width: 60px">
              <span class="ml-2 d-none d-lg-inline text-white small"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      </ul>
    </nav>
    <!-- Topbar -->

    <div class="container-fluid">
      @yield('content')
    </div>

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>copyright &copy; <script>
            document.write(new Date().getFullYear());
          </script> - developed by
          <b><a href="" target="_blank">diri sendiri</a></b>
        </span>
      </div>
    </div>
  </footer>
  <!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>
<script src="{{URL::asset('admin/ruangAdmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<!-- boostrap min -->
<script src="{{URL::asset('admin/ruangAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ruangadmin -->
<script src="{{URL::asset('admin/ruangAdmin/js/ruang-admin.min.js')}}"></script>
<!-- datatable -->
<script type="text/javascript" src="{{URL::asset('admin/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('admin/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('admin/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- sweetalert -->
<script src="{{URL::asset('admin/sweetalert/sweetalert2.all.min.js')}}"></script>
<!-- selet2 -->
  <script src="{{URL::asset('admin/select2/js/select2.min.js')}}"> </script>
</body>
@yield('script')
</html>
