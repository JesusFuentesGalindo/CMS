'use strict';
var path_url=window.location.protocol+'//'+window.location.host;
var brands;

$(document).ready(function(){
     $('#link_marcas').addClass('active');
    /**
     * Leer marcas
     */
    function read_brands(){
        
        let num_brands=0;
        brands=$('#tbl_brands').DataTable({
            'ajax':{            
                'url':path_url+'/marcas/read_brands', 
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
                {'data':'b_description','title':'Descripción'},
                {'data':'b_equipments','title':'Equipos'},
                {'data':'b_aplication','title':'Aplicaciones'},
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
        $('#brand_edit_txt_description').val(fila.find('td:eq(4)').text());
        $('#brand_edit_txt_equipments').val(fila.find('td:eq(5)').text());
        $('#brand_edit_txt_aplication').val(fila.find('td:eq(6)').text());
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
            let b_description=$('#brand_edit_txt_description').val();
            let b_equipments=$('#brand_edit_txt_equipments').val();
            let b_aplication=$('#brand_edit_txt_aplication').val();
            
            formData.append('b_id',b_id);
            formData.append('b_name',b_name);
            formData.append('b_img',b_img);
            formData.append('b_description',b_description);
            formData.append('b_equipments',b_equipments);
            formData.append('b_aplication',b_aplication);
            
            $.ajax({
                url:path_url+'/marcas/update_brand',
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                cache:false,
                success:function(response){
                    console.log(response);
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
    
    read_brands();
});