<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <!--Boton mostrar/ocultar menú lateral-->
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?=base_url('gestorUsuarios/logout')?>">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        
        <!-- Brand Logo -->
        <a href="http://geascientific.net/" class="brand-link">
          <img src="<?=base_url()?>/assets/dist/img/AdminLTELogo.png" alt="Gea Scientific Logo" class="brand-image img-circle elevation-3"
               style="opacity: .8">
          <span class="brand-text font-weight-light">Gea Scientific</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?=base_url().$auth_photo?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a id="link_gestor_usuarios" href="<?=base_url('gestorUsuarios')?>" class="d-block active"><?=$auth_username?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a id="link_dashboard" href="<?=base_url()?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a id="link_pagina_principal" href="<?=base_url('pagina_principal')?>" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Página Principal</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a id="link_productos" href="<?=base_url('productos')?>" class="nav-link">
                            <i class="nav-icon ion ion-beaker"></i>
                            <p>Productos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="link_marcas" href="<?=base_url('marcas')?>" class="nav-link">
                            <i class="nav-icon ion ion-closed-captioning"></i>
                            <p>Marcas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="link_aplicaciones" href="<?=base_url('aplicaciones')?>" class="nav-link">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>Aplicaciones</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="link_servicios" href="<?=base_url('servicios')?>" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Servicios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="link_consumibles" href="<?=base_url('consumibles')?>" class="nav-link">
                          <i class="nav-icon fas fa-toolbox"></i>
                          <p>Consumibles</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <?php $this->load->view($module); ?>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020-2021 <a href="http://geascientific.net/">Gea Scientific</a>.</strong>
        Todos los derechos reservados.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.1
        </div>
    </footer>

</div>
<!-- ./wrapper -->