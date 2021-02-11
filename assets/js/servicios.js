'use strict';
var path_url=window.location.protocol+'//'+window.location.host;
var services;

$(document).ready(function(){
    
    $('#link_servicios').addClass('active');
    
    /**
     * Leer servicios
     */
    function read_services(){
        
        let num_services=0;
        services=$('#tbl_services').DataTable({
            'ajax':{            
                'url':path_url+'/servicios/read_services', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'s_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                }},
                {'data':'s_img','title':'Imagen','render':function(data){
                        return '<img id="img_'+(num_services++)+'" class="img-thumbnail" width="50px" src="'+path_url+'/'+data+'"/>';
                }},
                {'data':'username','title':'Usuario'},
                {'data':'s_title','title':'Título'},
                {'data':'s_description','title':'Descripción'},
                {'data':'s_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button s_id="'+data+'" class="btn btn-primary btn-sm edit_service"><i class="fas fa-edit"></i></button><button type="button" s_id="'+data+'" class="btn btn-danger btn-sm delete_service"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Agregar servicio
     */
    
    $('#btn_create_service').on('click',function(){
        
        $("#frm_create_service").trigger("reset");
        $('#create_img_previa').attr('src',path_url+'/assets/img/servicios/default.jpg');
        $('#modal_create_service').modal('show');
    });
    
    $('#frm_create_service').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let s_img=document.getElementById('create_img_service').files[0];
            let s_title=$('#create_txt_title').val();
            let s_description=$('#create_txt_description').val();
            
            formData.append('s_title',s_title);
            formData.append('s_img',s_img);
            formData.append('s_description',s_description);
            
            $.ajax({
                url:path_url+'/servicios/create_service',
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                cache:false,
                success:function(response){
                    response=JSON.parse(response);
                    if(response.error){
                        
                        Swal.fire(
                            'Error!',
                            response.error.message,
                            'error'
                        );
                    }
                    else{
                        services.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                        );
                        $('#modal_create_service').modal('hide');
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El servicio no pudo ser creado!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Seleccionar imagen
     */
        $('.img_form').on('change',function(){
            let img=this.files[0];
            //validar que es jpg|png
            if(img['type']!='image/jpeg' && img['type']!='image/png'){
                $(this).val("");
                Swal.fire(
                    'Error!',
                    'La imagen debe ser jpeg o png!',
                    'error'
                );
            }
            else if(img['size']>250000){
                $(this).val("");
                Swal.fire(
                    'Error!',
                    'La imagen no debe pesar más de 200 Kilobytes!',
                    'error'
                );
            }
            else{
                
                let datos_img=new FileReader;
                datos_img.readAsDataURL(img);
                
                $(datos_img).on('load',function(event){
                   var rutaImagen=event.target.result;
                   $('.img_previa').attr('src',rutaImagen);
                });
            }
        });
    // --------------------------------------------------------------
    
    /**
     * Editar servicio
     */
    $(document).on("click", ".edit_service", function(){
       
        $("#frm_edit_service").trigger("reset");
        let fila=$(this).closest("tr");
        let s_id=fila.find('td:eq(0)').html();
        $('#edit_txt_title').val(fila.find('td:eq(3)').text()).attr('s_id',$(s_id).val());
        $('#edit_txt_description').val(fila.find('td:eq(4)').text());
        let img=fila.find('td:eq(1)').html();
        $('#edit_img_previa').attr('src',$(img).attr('src')).attr('id_img',$(img).attr('id'));
        $('#modal_edit_service').modal('show');
    });
    
    $('#frm_edit_service').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let s_id=$('#edit_txt_title').attr('s_id');
            let s_img=document.getElementById('edit_img_service').files[0];
            let s_title=$('#edit_txt_title').val();
            let s_description=$('#edit_txt_description').val();
            
            formData.append('s_id',s_id);
            formData.append('s_img',s_img);
            formData.append('s_title',s_title);
            formData.append('s_description',s_description);
            
            $.ajax({
                url:path_url+'/servicios/update_service',
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                cache:false,
                success:function(response){
                    
                    response=JSON.parse(response);
                    if(response.error){
                        
                        Swal.fire(
                            'Error!',
                            response.error.message,
                            'error'
                          );
                    }
                    else{
                        
                        services.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                          );
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El servicio no puedo ser actualizado!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar consumible
     */ 
    $(document).on("click", ".delete_service", function(){
        
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
            if (result.value) {;
                let s_id=$(this).attr('s_id');
                $.ajax({
                    url:path_url+'/servicios/delete_service',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'s_id='+s_id,
                    success:function(response){
                        
                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            services.ajax.reload(null, false);
                            Swal.fire(
                                'Exito!',
                                response.message,
                                'success'
                            );
                        }
                    },
                    error:function(error){
                        console.log(error);
                        Swal.fire(
                            'Error!',
                            'El servicio no pudo ser eliminado!',
                            'error'
                          );
                    }
                });
            } else if (
          /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El servicio NO fue eliminado',
                    'error'
                );
            }
        });
    });
    // --------------------------------------------------------------
    
    read_services();
});