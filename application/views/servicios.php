<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Servicios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Servicios</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('servicios/servicios')?>
    </section>
    <!-- /.content -->
    <?php $this->load->view('servicios/modal_agregar_servicio')?>
    <?php $this->load->view('servicios/modal_editar_servicio')?>
</div>
<!-- /.content-wrapper -->

