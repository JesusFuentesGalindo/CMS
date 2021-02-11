'use strict';
var path_url=window.location.protocol+'//'+window.location.host;

$(document).ready(function(){
    
    /**
     * Agregar usuario
     */
    $('#frm_add_user').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let username=$('#frm_add_user #txt_username').val();
            let email=$('#frm_add_user #txt_email').val();
            let passwd=$('#frm_add_user #txt_contrasenia').val();
            
            let user={
                'username':username,
                'email':email,
                'passwd':passwd
            };
            
            $.ajax({
                url:path_url+'/gestorUsuarios/crear_usuario',
                type:"POST",
                dataType:"json",
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data:user,
                success:function(response){
                    Swal.fire(
                        'Usuario Creado!',
                        'El usuario '+user.username+' ha sido creado!',
                        'success'
                      );
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El usuario '+user.username+' no puedo ser creado!',
                        'error'
                      );
                    console.log(error);
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar usuario
     */
    $('.btn_delete').on('click',function(){
        
        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              });

        swalWithBootstrapButtons.fire({
    
            title: 'Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminalo!',
            cancelButtonText: 'No, cancela!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                let user_id=$(this).attr('id');
                $.ajax({
                    url:path_url+'/gestorUsuarios/eliminar_usuario',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'user_id='+user_id,
                    success:function(response){
                        Swal.fire(
                            'Usuario Eliminado!',
                            'El usuario ha sido eliminado!',
                            'success'
                        );
                        $('#'+user_id).parent().parent().remove();  
                    },
                    error:function(error){
                        Swal.fire(
                            'Error!',
                            'El usuario no puedo ser eliminado!',
                            'error'
                          );
                        console.log(error);
                    }
                });
            } else if (
          /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El usuario NO fue eliminado',
                    'error'
                );
            }
        });
    });
       
        /**
     * Seleccionar imagen
     */
        $('#img_foto').on('change',function(){
            let img=this.files[0];
//            validar que es jpg|png
            if(img['type']!='image/jpeg' && img['type']!='image/png'){
                $(this).val("");
                Swal.fire(
                    'Error!',
                    'La imagen debe ser jpeg o png!',
                    'error'
                );
            }
            else if(img['size']>2500000){
                $(this).val("");
                Swal.fire(
                    'Error!',
                    'La imagen no debe pesar más de 2 Megabytes!',
                    'error'
                );
            }
            else{
                
                let datos_img=new FileReader;
                datos_img.readAsDataURL(img);
                
                $(datos_img).on('load',function(event){
                   var rutaImagen=event.target.result;
                   $('#img_previa').attr('src',rutaImagen);
                });
            }
        });
    // --------------------------------------------------------------
    
    /**
     * Editar usuario
     */
    $('#frm_edit_user').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            var photo = document.getElementById('img_foto').files[0];
            let username=$('#frm_edit_user #edit_txt_username').val();
            let email=$('#frm_edit_user #edit_txt_email').val();
            let passwd=$('#frm_edit_user #edit_txt_contrasenia').val();
            
            let user={
                'username':username,
                'email':email,
                'passwd':passwd,
                'photo':photo
            };
            
            formData.append('username',username);
            formData.append('email',email);
            formData.append('passwd',passwd);
            formData.append('photo',photo);
            
            console.log(formData);
            $.ajax({
                url:path_url+'/gestorUsuarios/actualizar_usuario',
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                cache:false,
                success:function(response){
                    Swal.fire(
                        'Usuario Actualizado!',
                        'El usuario '+formData.username+' ha sido actualizado!',
                        'success'
                      );
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El usuario '+formData.username+' no puedo ser actualizado!',
                        'error'
                      );
                    console.log(error);
                }
            });
        }
    });
    
    $('#tbl_lista_usuarios').DataTable({
        responsive: true
    });
    
    $('#btn_edit').on('click',function(){
       
        $('#modal_edit').modal('show');
    });
    
    $('#btn_add').on('click',function(){
       
        $('#modal_add').modal('show');
    });
    
    
});
    // --------------------------------------------------------------
    



