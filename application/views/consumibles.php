<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Consumibles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Consumibles</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('consumibles/consumibles')?>
    </section>
    <!-- /.content -->
    <?php $this->load->view('consumibles/modal_agregar_consumible')?>
    <?php $this->load->view('consumibles/modal_editar_consumible')?>
</div>
<!-- /.content-wrapper -->

