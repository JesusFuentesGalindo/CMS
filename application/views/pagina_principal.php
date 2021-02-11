<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
                <h1>Página Principal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Página Principal</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('pagina_principal/avisos')?>
        <?php $this->load->view('pagina_principal/marcas')?>
    </section>
    <!-- /.content -->
    <?php $this->load->view('pagina_principal/modal_agregar_aviso')?>
    <?php $this->load->view('pagina_principal/modal_editar_aviso')?>
    <?php $this->load->view('pagina_principal/modal_agregar_marca')?>
    <?php $this->load->view('pagina_principal/modal_editar_marca')?>
</div>
<!-- /.content-wrapper -->