<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Aplicaciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Aplicaciones</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('aplicaciones/aplicaciones')?>
        <?php $this->load->view('aplicaciones/equipos')?>
    </section>
    <!-- /.content -->
    
    
    <?php $this->load->view('aplicaciones/modal_agregar_aplicacion')?>
    <?php $this->load->view('aplicaciones/modal_editar_aplicacion')?>
    <?php $this->load->view('aplicaciones/modal_ligar_equipo')?>
    <?php $this->load->view('aplicaciones/modal_editar_equipo')?>
</div>
<!-- /.content-wrapper -->



