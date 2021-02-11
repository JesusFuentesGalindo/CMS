'use strict';
var path_url=window.location.protocol+'//'+window.location.host;
var aplications;
var equipments;

$(document).ready(function(){
    
    $('#link_aplicaciones').addClass('active');
    
    /* ************************ *
     * ***** Aplicaciones ***** *
     * ************************ */
    
    /**
     * Leer aplicaciones
     */
    function read_aplications(){
        
        let num_aplications=0;
        aplications=$('#tbl_aplications').DataTable({
            'ajax':{            
                'url':path_url+'/aplicaciones/read_aplications', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'a_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                }},
                {'data':'a_img','title':'Imagen','render':function(data){
                        return '<img id="img_'+(num_aplications++)+'" class="img-thumbnail" width="50px" src="'+path_url+'/'+data+'"/>';
                }},
                {'data':'username','title':'Usuario'},
                {'data':'a_name','title':'Nombre'},
                {'data':'a_description','title':'Descripción'},
                {'data':'a_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button a_id="'+data+'" class="btn btn-primary btn-sm edit_aplication"><i class="fas fa-edit"></i></button><button type="button" a_id="'+data+'" class="btn btn-danger btn-sm delete_aplication"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Agregar aplicación
     */
    
    $('#btn_create_aplication').on('click',function(){
        
        $("#frm_create_aplication").trigger("reset");
        $('#create_img_previa').attr('src',path_url+'/assets/img/aplicaciones/default.png');
        $('#modal_create_aplication').modal('show');
    });
    
    $('#frm_create_aplication').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let a_img=document.getElementById('create_img_aplication').files[0];
            let a_name=$('#create_txt_nombre').val();
            let a_description=$('#create_txt_description').val();
            
            formData.append('a_name',a_name);
            formData.append('a_description',a_description);
            formData.append('a_img',a_img);
            
            $.ajax({
                url:path_url+'/aplicaciones/create_aplication',
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
                        aplications.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                        );
                        $('#modal_create_aplication').modal('hide');
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'La aplicación no pudo ser creada!',
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
     * Editar aplicación
     */
    $(document).on("click", ".edit_aplication", function(){
       
        $("#frm_edit_aplication").trigger("reset");
        let fila=$(this).closest("tr");
        let a_id=fila.find('td:eq(0)').html();
        $('#edit_txt_nombre').val(fila.find('td:eq(3)').text()).attr('a_id',$(a_id).val());
        $('#edit_txt_description').val(fila.find('td:eq(4)').text());
        let img=fila.find('td:eq(1)').html();
        $('#edit_img_previa').attr('src',$(img).attr('src')).attr('id_img',$(img).attr('id'));
        $('#modal_edit_aplication').modal('show');
    });
    
    $('#frm_edit_aplication').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let a_id=$('#edit_txt_nombre').attr('a_id');
            let a_img=document.getElementById('edit_img_aplication').files[0];
            let a_name=$('#edit_txt_nombre').val();
            let a_description=$('#edit_txt_description').val();
            
            formData.append('a_id',a_id);
            formData.append('a_name',a_name);
            formData.append('a_description',a_description);
            formData.append('a_img',a_img);
            
            $.ajax({
                url:path_url+'/aplicaciones/update_aplication',
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
                        
                        aplications.ajax.reload(null, false);
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
                        'La aplicación no puedo ser actualizada!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar aplicación
     */ 
    $(document).on("click", ".delete_aplication", function(){
        
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
                let a_id=$(this).attr('a_id');
                $.ajax({
                    url:path_url+'/aplicaciones/delete_aplication',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'a_id='+a_id,
                    success:function(response){
                        
                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            aplications.ajax.reload(null, false);
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
                            'La aplicación no pudo ser eliminada!',
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
                    'La aplicación NO fue eliminada',
                    'error'
                );
            }
        });
    });
    // --------------------------------------------------------------
    
    /* ******************* *
     * ***** Equipos ***** *
     * ******************* */
    
    /**
     * Leer Equipos
     */
    function read_equipments(){
        
        let num_equipments=0;
        equipments=$('#tbl_equipos').DataTable({
            'ajax':{            
                'url':path_url+'/aplicaciones/read_equipments', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'pa_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                }},
                {'data':'a_id','title':'Id Aplicación'},
                {'data':'a_name','title':'Aplicación'},
                {'data':'pa_name','title':'Equipo'},
                {'data':'pa_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button pa_id="'+data+'" class="btn btn-primary btn-sm edit_equipment"><i class="fas fa-edit"></i></button><button type="button" pa_id="'+data+'" class="btn btn-danger btn-sm delete_equipment"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Ligar equipo
     */
    
    $('#btn_link_equipment').on('click',function(){
        
        $("#frm_link_equipment").trigger("reset");
        $('#modal_link_equipment').modal('show');
    });
    
    $('#frm_link_equipment').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let a_id=$('#select_equipo').val();
            let pa_name=$('#create_txt_equipo').val();
            
            formData.append('a_id',a_id);
            formData.append('pa_name',pa_name);
            
            $.ajax({
                url:path_url+'/aplicaciones/link_equipment',
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
                        equipments.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                        );
                        $('#modal_link_equipment').modal('hide');
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'La aplicación no pudo ser creada!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Editar aplicación
     */
    $(document).on("click", ".edit_equipment", function(){
       
        $("#frm_edit_equipment").trigger("reset");
        let fila=$(this).closest("tr");
        let pa_id=fila.find('td:eq(0)').html();
        $('#edit_select_equipo').val(fila.find('td:eq(1)').text()).attr('pa_id',$(pa_id).val());
        $('#edit_txt_equipo').val(fila.find('td:eq(3)').text());
        $('#modal_edit_equipment').modal('show');
    });
    
    $('#frm_edit_equipment').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let pa_id=$('#edit_select_equipo').attr('pa_id');
            let a_id=$('#edit_select_equipo').val();
            let pa_name=$('#edit_txt_equipo').val();
            
            formData.append('pa_id',pa_id);
            formData.append('a_id',a_id);
            formData.append('pa_name',pa_name);
            
            $.ajax({
                url:path_url+'/aplicaciones/update_equipment',
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
                        
                        equipments.ajax.reload(null, false);
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
                        'La aplicación no puedo ser actualizada!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar equipo
     */ 
    $(document).on("click", ".delete_equipment", function(){
        
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
                let pa_id=$(this).attr('pa_id');
                $.ajax({
                    url:path_url+'/aplicaciones/delete_equipment',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'pa_id='+pa_id,
                    success:function(response){
                        
                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            equipments.ajax.reload(null, false);
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
                            'La aplicación no pudo ser eliminada!',
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
                    'La aplicación NO fue eliminada',
                    'error'
                );
            }
        });
    });
    // --------------------------------------------------------------
    
    read_aplications();
    read_equipments();
});