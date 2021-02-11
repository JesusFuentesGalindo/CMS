<section>
    <div class="row">
        <div class="col-lg-4 col-6">
        <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3><?=$num_avisos?></h3>
                <p>Avisos</p>
            </div>
            <div class="icon">
                <i class="ion ion-alert-circled"></i>
            </div>
            <a href="<?=base_url('pagina_principal')?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?=$num_marcas?></h3>
                    <p>Marcas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-closed-captioning"></i>
                </div>
                <a href="<?=base_url('marcas')?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?=$num_productos?></h3>
                    <p>Productos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-beaker"></i>
                </div>
                <a href="<?=base_url('productos')?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="row">
        <div class="col-lg-4 col-6">
        <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3><?=$num_aplicaciones?></h3>
                <p>Aplicaciones</p>
            </div>
            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>
            <a href="<?=base_url('aplicaciones')?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?=$num_services?></h3>
                    <p>Servicios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="<?=base_url('servicios')?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?=$num_consumibles?></h3>
                    <p>Consumibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-toolbox"></i>
                </div>
                <a href="<?=base_url('consumibles')?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
</section>