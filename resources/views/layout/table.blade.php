<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PEID - Dashboard</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('/dash/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('/dash/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('/dash/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <svg width="43" height="43" viewBox="0 0 113 113" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M56.6008 112.7C25.5008 112.7 0.300781 87.5001 0.300781 56.4001C0.300781 25.3001 25.5008 0.100098 56.6008 0.100098C87.7008 0.100098 112.901 25.3001 112.901 56.4001C112.801 87.5001 87.7008 112.7 56.6008 112.7Z" fill="#FFF800"/>
                    <path d="M51.0009 70.5003V32.3003H34.4009V80.7003H40.9009C46.4009 80.6003 51.0009 76.1003 51.0009 70.5003Z" fill="#FFF800"/>
                    <path d="M78.801 51.1003C78.801 37.5003 66.401 32.4003 58.501 32.3003V69.9003C66.501 69.8003 78.801 64.6003 78.801 51.1003Z" fill="#F15B5B"/>
                    <path d="M57.1008 77.4003H58.3008C65.0008 77.4003 71.8008 75.1003 76.9008 71.1003C81.2008 67.7003 86.4008 61.4003 86.4008 51.1003C86.4008 34.0003 71.9008 24.8003 58.3008 24.8003H54.8008H30.6008C28.5008 24.8003 26.8008 26.5003 26.8008 28.6003V84.5003C26.8008 86.6003 28.5008 88.3003 30.6008 88.3003H40.9008C48.1008 88.2003 54.4008 83.7003 57.1008 77.4003ZM58.5008 32.3003C66.5008 32.4003 78.8008 37.5003 78.8008 51.1003C78.8008 64.7003 66.4008 69.8003 58.5008 69.9003V32.3003ZM34.3008 32.3003H51.0008V70.5003C51.0008 76.1003 46.5008 80.6003 40.9008 80.6003H34.4008V32.3003H34.3008Z" fill="#062825"/>
                </svg>
            </div>
            <div class="sidebar-brand-text mx-3">PEID<sup> PANEL</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Reporte
        </div>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tablas</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <form class="form-inline">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </form>

                <!-- Topbar Search -->
                <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                               aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                           placeholder="Search for..." aria-label="Search"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Joseph David</span>
                            <img class="img-profile rounded-circle"
                                 src="{{ asset('/dash/img/undraw_profile.svg') }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">DNIS</h1>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Relación de DNIS creados</h6>
                    </div>
                    <form class="form-inline p-2 ml-2 my-3">
                        <!-- https://solibeth.net/laravel-6-22-filtros-de-busqueda -->
                        <input name="buscarpor" class="form-control mr-sm-2" type="search" placeholder="Buscar por dni" aria-label="Search">
                        <input name="buscarporapellido" class="form-control mr-sm-2" type="search" placeholder="Buscar por apellido" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>dni_number_pet</th>
                                    <th>dni_type_pet</th>
                                    <th>lastname_pet</th>
                                    <th>name_pet</th>
                                    <th>url_image_pet</th>
                                    <th>birthday_pet</th>
                                    <th>date_enrollment_pet</th>
                                    <th>date_issue_pet</th>
                                    <th>date_expiry_pet</th>
                                    <th>gender_pet</th>
                                    <th>specie_type_pet</th>
                                    <th>breed_pet</th>
                                    <th>lastname_owner</th>
                                    <th>name_owner</th>
                                    <th>country_code</th>
                                    <th>cellphone_owner</th>
                                    <th>email_owner</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dnis as $dni)
                                <tr>
                                    <td>{{ $dni->dni_number_pet }}</td>
                                    <td>{{ $dni->dni_type_pet }}</td>
                                    <td>{{ $dni->lastname_pet }}</td>
                                    <td>{{ $dni->name_pet }}</td>
                                    <td>
                                    
                                        <img  width="40" height="40" src="{{ asset('/dash/img/undraw_profile.svg') }}" alt="">
                                    </td>
                                    <td>{{ $dni->birthday_pet }}</td>
                                    <td>{{ $dni->date_enrollment_pet }}</td>
                                    <td>{{ $dni->date_issue_pet }}</td>
                                    <td>{{ $dni->date_expiry_pet }}</td>
                                    <td>{{ $dni->gender_pet }}</td>
                                    <td>{{ $dni->specie_type_pet }}</td>
                                    <td>{{ $dni->breed_pet }}</td>
                                    <td>{{ $dni->lastname_owner }}</td>
                                    <td>{{ $dni->name_owner }}</td>
                                    <td>{{ $dni->country_code }}</td>
                                    <td>{{ $dni->cellphone_owner }}</td>
                                    <td>{{ $dni->email_owner }}</td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>PEID &copy; 2021</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('/dash/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/dash/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/dash/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('/dash/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('/dash/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/dash/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

</body>

</html>
