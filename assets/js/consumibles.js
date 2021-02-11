'use strict';
var path_url=window.location.protocol+'//'+window.location.host;
var consumables;

$(document).ready(function(){
    
    $('#link_consumibles').addClass('active');
    
    /**
     * Leer consumibles
     */
    function read_consumables(){
        
        let num_consumables=0;
        consumables=$('#tbl_consumable').DataTable({
            'ajax':{            
                'url':path_url+'/consumibles/read_consumables', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'c_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                }},
                {'data':'c_img','title':'Imagen','render':function(data){
                        return '<img id="img_'+(num_consumables++)+'" class="img-thumbnail" width="50px" src="'+path_url+'/'+data+'"/>';
                }},
                {'data':'username','title':'Usuario'},
                {'data':'c_name','title':'Nombre'},
                {'data':'c_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button p_id="'+data+'" class="btn btn-primary btn-sm edit_consumable"><i class="fas fa-edit"></i></button><button type="button" c_id="'+data+'" class="btn btn-danger btn-sm delete_consumable"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Agregar consumible
     */
    
    $('#btn_create_consumable').on('click',function(){
        
        $("#frm_create_consumable").trigger("reset");
        $('#create_img_previa').attr('src',path_url+'/assets/img/consumibles/default.jpg');
        $('#modal_create_consumable').modal('show');
    });
    
    $('#frm_create_consumable').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let c_img=document.getElementById('create_img_consumable').files[0];
            let c_name=$('#create_txt_nombre').val();
            
            formData.append('c_name',c_name);
            formData.append('c_img',c_img);
            
            $.ajax({
                url:path_url+'/consumibles/create_consumable',
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
                        consumables.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                        );
                        $('#modal_create_consumable').modal('hide');
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El consumible no pudo ser creado!',
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
     * Editar consumible
     */
    $(document).on("click", ".edit_consumable", function(){
       
        $("#frm_edit_consumable").trigger("reset");
        let fila=$(this).closest("tr");
        let c_id=fila.find('td:eq(0)').html();
        $('#edit_txt_nombre').val(fila.find('td:eq(3)').text()).attr('c_id',$(c_id).val());
        let img=fila.find('td:eq(1)').html();
        $('#edit_img_previa').attr('src',$(img).attr('src')).attr('id_img',$(img).attr('id'));
        $('#modal_edit_consumable').modal('show');
    });
    
    $('#frm_edit_consumable').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let c_id=$('#edit_txt_nombre').attr('c_id');
            let c_img=document.getElementById('edit_img_consumable').files[0];
            let c_name=$('#edit_txt_nombre').val();
            
            formData.append('c_id',c_id);
            formData.append('c_name',c_name);
            formData.append('c_img',c_img);
            
            $.ajax({
                url:path_url+'/consumibles/update_consumable',
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
                        
                        consumables.ajax.reload(null, false);
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
                        'El consumible no puedo ser actualizado!',
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
    $(document).on("click", ".delete_consumable", function(){
        
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
                let c_id=$(this).attr('c_id');
                $.ajax({
                    url:path_url+'/consumibles/delete_consumable',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'c_id='+c_id,
                    success:function(response){
                        
                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            consumables.ajax.reload(null, false);
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
                            'El consumible no pudo ser eliminado!',
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
                    'El consumible NO fue eliminado',
                    'error'
                );
            }
        });
    });
    // --------------------------------------------------------------
    
    read_consumables();
});