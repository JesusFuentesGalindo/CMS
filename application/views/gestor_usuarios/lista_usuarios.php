
<div id="lista_usuarios" class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Usuarios</h3>
        <button id="btn_add" type="button" class="btn btn-success btn-sm">Agregar</button>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tbl_lista_usuarios" class="table table-bordered table-striped dataTable">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Usuario</th>
                    <th>Mail</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <?php if($usuario['user_id']!=$auth_user_id): ?>
                    <tr>
                        <td><img class="direct-chat-img" src="<?=base_url().$usuario['photo']?>" alt="user image"></td>
                        <td><?=$usuario['username']?></td>
                        <td><?=$usuario['email']?></td>
                        <td><button id="<?=$usuario['user_id']?>" type="button" class="btn btn-danger btn-sm btn_delete"><i class="fas fa-eraser"></i></button></td>
                    </tr>
                    <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>