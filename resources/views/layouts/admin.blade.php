
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library</title>


  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
            <form class="form-inline">
                <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
            </form>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span id="notification-count" class="badge badge-warning navbar-badge"></span>
            </a>
            <div id="notifications" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
            </form>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

 

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <!-- <a href="#" class="d-block">Alexander Pierce</a> -->
            <a  class="d-block">
                 {{ Auth::user()->name }}
            </a>
        </div>
      </div>

      

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{url('dashboard')}}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('transactions')}}" class="nav-link {{ request()->is('transactions') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                Transaction
              </p>
            </a>
          </li>
       
          <!-- Book Menu -->
          <li class="nav-item">
            <a href="{{url('books')}}" class="nav-link {{ request()->is('books') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Book
              </p>
            </a>
          </li>
         

          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Data Master
                  <i class="right fas fa-angle-left"></i>
                </p>
            </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{url('catalogs')}}" class="nav-link {{ request()->is('catalogs') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Catalog
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('publishers')}}" class="nav-link {{ request()->is('publishers') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Publisher
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('authors')}}" class="nav-link {{ request()->is('authors') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Author
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('members')}}" class="nav-link {{ request()->is('members') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Member
              </p>
            </a>
          </li>
          </ul>
          </li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('header')</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
        @yield('content')
        </div>
    </section>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>

<!-- Vue Js 3 -->
<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->

<!-- Vue Js 2 -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

<!-- axios js -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- Tambahkan kode JavaScript berikut di bawah tag </footer> -->
<script>
async function checkOverdueTransactions() {
    try {
        const response = await fetch('/api/transactions');
        const transactions = await response.json();
        const notifications = document.getElementById('notifications');
        const notificationCount = document.getElementById('notification-count'); // Mengambil elemen angka notifikasi
        const today = new Date();
        let overdueCount = 0; // Menghitung jumlah notifikasi yang kadaluwarsa

        notifications.innerHTML = '';

        transactions.forEach((transaction) => {
            const transactionDate = new Date(transaction.date_end);
            if (transactionDate < today) {
                overdueCount++;
                const notificationItem = document.createElement('a');
                notificationItem.className = 'dropdown-item';
                notificationItem.innerHTML = `
                    <i class="fas fa-exclamation-triangle mr-2"></i>${transaction.description}
                    <span class="float-right text-muted text-sm">Overdue</span>
                `;
                notifications.appendChild(notificationItem);
            }
        });

        // Perbarui angka notifikasi dengan jumlah notifikasi yang kadaluwarsa
        notificationCount.innerText = overdueCount.toString();
    } catch (error) {
        console.error('Error fetching and processing transactions:', error);
    }
}
window.onload = () => {
    checkOverdueTransactions();
};
</script>

@yield('js')
</body>
</html>
