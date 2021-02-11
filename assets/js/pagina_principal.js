'use strict';
var path_url=window.location.protocol+'//'+window.location.host;
var avisos;
var brands;
var text_postions={
            '1':'1 izquierda-arriba',
            '2':'2 centro-arriba',
            '3':'3 derecha-arriba',
            '4':'4 izquierda-centro',
            '5':'5 centro-centro',
            '6':'6 derecha-centro',
            '7':'7 izquierda-abajo',
            '8':'8 centro-abajo',
            '9':'9 derecha-abajo'
        };

$(document).ready(function(){
    
    $('#link_pagina_principal').addClass('active');
    
    /*
     * ****************** *
     * ***** Avisos ***** *
     * ****************** *
     */
    
    $('.my-colorpicker2').colorpicker();
    $('.my-colorpicker2').on('colorpickerChange',function(event){
            $('.my-colorpicker2 .fa-square').css('color',event.color.toString());
        });
        
    /**
     * Leer avisos
     */
    function read_notices(){
        
        let num_notices=0;
        avisos=$('#tbl_avisos').DataTable({
            'ajax':{            
                'url':path_url+'/pagina_principal/leer_avisos', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'n_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                },'width':'.5%'},
                {'data':'n_img','title':'Imagen','render':function(data){
                        return '<img id="img_'+(num_notices++)+'" class="img-thumbnail" width="50px" src="'+path_url+'/'+data+'"/>';
                }},
                {'data':'username','title':'Usuario'},
                {'data':'n_name','title':'Nombre'},
                {'data':'n_text','title':'Texto'},
                {'data':'n_text_position','title':'Posición','render':function(data){
                        return text_postions[data];
                }},
                {'data':'n_text_color','title':'Color de texto'},
                {'data':'n_product','title':'Producto'},
                {'data':'n_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button n_id="'+data+'" class="btn btn-primary btn-sm edit_notice"><i class="fas fa-edit"></i></button><button type="button" n_id="'+data+'" class="btn btn-danger btn-sm delete_notice"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Agregar aviso
     */
    
    $('#btn_crear_aviso').on('click',function(){
        
        $("#frm_agregar_aviso").trigger("reset");
        $('#create_img_previa').attr('src',path_url+'/assets/img/avisos/default.jpg');
        $('.my-colorpicker2 .fa-square').css('color','#060606');
        
        $('#modal_agregar_aviso').modal('show');
    });
    
    $('#frm_agregar_aviso').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let n_img=document.getElementById('img_aviso').files[0];
            let n_name=$('#frm_agregar_aviso #txt_nombre').val();
            let n_text=$('#frm_agregar_aviso #txt_texto').val();
            let n_text_position=$('#frm_agregar_aviso #select_posicion').val();
            let n_text_color=$('#frm_agregar_aviso #text_color').val();
            let n_product=$('#frm_agregar_aviso #select_producto').val();
            
            formData.append('n_name',n_name);
            formData.append('n_text',n_text);
            formData.append('n_text_position',n_text_position);
            formData.append('n_img',n_img);
            formData.append('n_text_color',n_text_color);
            formData.append('n_product',n_product);
            
            $.ajax({
                url:path_url+'/pagina_principal/create_notice',
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
                        avisos.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                        );
                        $('#modal_agregar_aviso').modal('hide');
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El aviso no pudo ser creado!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar aviso
     */ 
    $(document).on("click", ".delete_notice", function(){
        
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
                let n_id=$(this).attr('n_id');
                $.ajax({
                    url:path_url+'/pagina_principal/delete_notice',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'n_id='+n_id,
                    success:function(response){
                        
                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            avisos.ajax.reload(null, false);
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
                            'El aviso no pudo ser eliminado!',
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
                    'El aviso NO fue eliminado',
                    'error'
                );
            }
        });
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
     * Editar aviso
     */
    $(document).on("click", ".edit_notice", function(){
       
        $("#frm_edit_notice").trigger("reset");
        let fila=$(this).closest("tr");
        let n_id=fila.find('td:eq(0)').html();
        $('#edit_txt_nombre').val(fila.find('td:eq(3)').text()).attr('n_id',$(n_id).val());
        $('#edit_txt_texto').val(fila.find('td:eq(4)').text());
        $('#edit_select_posicion').val(parseInt(fila.find('td:eq(5)').text().substr(0,1)));
        $('#edit_text_color').val(fila.find('td:eq(6)').text());
        $('.my-colorpicker2 .fa-square').css('color',fila.find('td:eq(6)').text().toString());
        $('#edit_select_producto').val(fila.find('td:eq(7)').text());
        let img=fila.find('td:eq(1)').html();
        $('#edit_img_previa').attr('src',$(img).attr('src')).attr('id_img',$(img).attr('id'));
        
        $('#modal_edit_notice').modal('show');
        
    });
    
    $('#frm_edit_notice').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let n_id=$('#frm_edit_notice #edit_txt_nombre').attr('n_id');
            let n_img=document.getElementById('edit_img_aviso').files[0];
            let n_name=$('#frm_edit_notice #edit_txt_nombre').val();
            let n_text=$('#frm_edit_notice #edit_txt_texto').val();
            let n_text_position=$('#frm_edit_notice #edit_select_posicion').val();
            let n_text_color=$('#frm_edit_notice #edit_text_color').val();
            let n_product=$('#frm_edit_notice #edit_select_producto').val();
            
            formData.append('n_id',n_id);
            formData.append('n_name',n_name);
            formData.append('n_text',n_text);
            formData.append('n_text_position',n_text_position);
            formData.append('n_img',n_img);
            formData.append('n_text_color',n_text_color);
            formData.append('n_product',n_product);
            
            $.ajax({
                url:path_url+'/pagina_principal/update_notice',
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
                        
                        avisos.ajax.reload(null, false);
                        Swal.fire(
                            'Aviso Actualizado!',
                            response.message,
                            'success'
                          );
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'El usuario '+formData.username+' no puedo ser actualizado!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /*
     * ****************** *
     * ***** Marcas ***** *
     * ****************** *
     */
    
    /**
     * Leer marcas
     */
    function read_brands(){
        
        let num_brands=0;
        brands=$('#tbl_brands').DataTable({
            'ajax':{            
                'url':path_url+'/pagina_principal/read_brands', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'b_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                },'width':'.5%'},
                {'data':'b_img','title':'Imagen','render':function(data){
                        return '<img id="brand_img_'+(num_brands++)+'" class="img-thumbnail" width="50px" src="'+path_url+'/'+data+'"/>';
                }},
                {'data':'username','title':'Usuario'},
                {'data':'b_name','title':'Nombre'},
                {'data':'b_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button b_id="'+data+'" class="btn btn-primary btn-sm edit_brand"><i class="fas fa-edit"></i></button><button type="button" b_id="'+data+'" class="btn btn-danger btn-sm delete_brand"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Agregar marca
     */
    
    $('#btn_create_brand').on('click',function(){
        
        $("#frm_create_brand").trigger("reset");
        $('#brand_create_img_previa').attr('src',path_url+'/assets/img/marcas/default.jpg');
        $('#modal_create_brand').modal('show');
    });
    
    $('#frm_create_brand').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let b_img=document.getElementById('brand_create_input_img').files[0];
            let b_name=$('#brand_create_txt_name').val();
            
            formData.append('b_name',b_name);
            formData.append('b_img',b_img);
            
            $.ajax({
                url:path_url+'/pagina_principal/create_brand',
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
                        brands.ajax.reload(null, false);
                        Swal.fire(
                            'Exito!',
                            response.message,
                            'success'
                        );
                        $('#modal_create_brand').modal('hide');
                    }
                },
                error:function(error){
                    Swal.fire(
                        'Error!',
                        'La marca no pudo ser creado!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Editar marca
     */
    $(document).on("click", ".edit_brand", function(){
       
        $("#frm_edit_brand").trigger("reset");
        let fila=$(this).closest("tr");
        let b_id=fila.find('td:eq(0)').html();
        $('#brand_edit_txt_name').val(fila.find('td:eq(3)').text()).attr('b_id',$(b_id).val());
        let img=fila.find('td:eq(1)').html();
        $('#brand_edit_img_previa').attr('src',$(img).attr('src')).attr('id_img',$(img).attr('id'));
        $('#modal_edit_brand').modal('show');
    });
    
    $('#frm_edit_brand').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let b_id=$('#brand_edit_txt_name').attr('b_id');
            let b_img=document.getElementById('brand_edit_input_img').files[0];
            let b_name=$('#brand_edit_txt_name').val();
            
            formData.append('b_id',b_id);
            formData.append('b_name',b_name);
            formData.append('b_img',b_img);
            
            $.ajax({
                url:path_url+'/pagina_principal/update_brand',
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
                        
                        brands.ajax.reload(null, false);
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
                        'La marca no puedo ser actualizada!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar marca
     */ 
    $(document).on("click", ".delete_brand", function(){
        
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
                let b_id=$(this).attr('b_id');
                $.ajax({
                    url:path_url+'/pagina_principal/delete_brand',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'b_id='+b_id,
                    success:function(response){

                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            brands.ajax.reload(null, false);
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
                            'La marca no pudo ser eliminada!',
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
                    'La marca NO fue eliminada',
                    'error'
                );
            }
        });
    });
    // --------------------------------------------------------------
    
    read_notices();
    read_brands();
    
    
});
// --------------------------------------------------------------
    



