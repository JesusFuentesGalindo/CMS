<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestor de Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Gestor de Usuarios</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
        <div class="card card-widget widget-user-2">
            <div class="card-header">
                <?php $this->load->view('gestor_usuarios/profile') ?>
            </div>
            <div class="card-body">
                <?php $this->load->view('gestor_usuarios/lista_usuarios') ?>
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <?php $this->load->view('gestor_usuarios/modal_edit') ?>
                <?php $this->load->view('gestor_usuarios/modal_add') ?>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->