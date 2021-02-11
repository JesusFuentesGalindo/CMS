<div id="profile" class="widget-user-header">
    <div class="widget-user-image">
        <img id="profile_img" class="img-circle elevation-2" src="<?=base_url().$auth_photo?>" alt="User Avatar">
    </div>
    <!-- /.widget-user-image -->
    <h3 id="profile_name" class="widget-user-username">
        <?=$auth_username?>
        <span id="btn_edit" class="badge badge-secondary right" toggle="modal" data-target="#modal_edit"><i class="fas fa-edit"></i></span>
    </h3>
    <h5 id="profile_rol" class="widget-user-desc"><?=$auth_role?> <span class="text-bold text-sm">&lt;&lt;<?=$auth_email?>&gt;&gt;</span></h5>
</div>

