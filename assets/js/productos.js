'use strict';
var path_url=window.location.protocol+'//'+window.location.host;
var products;

$(document).ready(function(){
    
    $('#link_productos').addClass('active');
    
    /**
     * Leer productos
     */
    function read_products(){
        
        let num_products=0;
        products=$('#tbl_products').DataTable({
            'ajax':{            
                'url':path_url+'/productos/read_products', 
                'method':'GET',
                'cache':'false',
                'dataSrc':''
            },
            'columns':[
                {'data':'p_id','render':function(data){
                        return '<input type="hidden" value="'+data+'"/>';
                }},
                {'data':'p_img','title':'Imagen','render':function(data){
                        return '<img id="img_'+(num_products++)+'" class="img-thumbnail" width="50px" src="'+path_url+'/'+data+'"/>';
                }},
                {'data':'username','title':'Usuario'},
                {'data':'p_name','title':'Nombre'},
                {'data':'p_equipments','title':'Equipos'},
                {'data':'p_offer','title':'Oferta'},
                {'data':'p_id','title':'Opciones','render':function(data){
                        let accion_buttons='<div class="text-center"><div class="btn-group"><button p_id="'+data+'" class="btn btn-primary btn-sm edit_product"><i class="fas fa-edit"></i></button><button type="button" p_id="'+data+'" class="btn btn-danger btn-sm delete_product"><i class="fas fa-eraser"></i></button></div></div>';
                        return accion_buttons;
                }}
            ],
            'responsive':true
        });
    }
    // --------------------------------------------------------------
    
    /**
     * Agregar producto
     */
    
    $('#btn_create_product').on('click',function(){
        
        $("#frm_create_product").trigger("reset");
        $('#create_img_previa').attr('src',path_url+'/assets/img/productos/default.jpg');
        $('#modal_create_product').modal('show');
    });
    
    $('#frm_create_product').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            
            let formData = new FormData();
            let p_img=document.getElementById('create_img_product').files[0];
            let p_name=$('#create_txt_nombre').val();
            let p_equipments=$('#create_txt_equipmets').val();
            let p_offer=$('#create_txt_offer').val();
            
            formData.append('p_name',p_name);
            formData.append('p_equipments',p_equipments);
            formData.append('p_offer',p_offer);
            formData.append('p_img',p_img);
            
            $.ajax({
                url:path_url+'/productos/create_product',
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
                        products.ajax.reload(null, false);
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
                        'El producto no pudo ser creado!',
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
     * Editar producto
     */
    $(document).on("click", ".edit_product", function(){
       
        $("#frm_edit_product").trigger("reset");
        let fila=$(this).closest("tr");
        let p_id=fila.find('td:eq(0)').html();
        $('#edit_txt_nombre').val(fila.find('td:eq(3)').text()).attr('p_id',$(p_id).val());
        $('#edit_txt_equipmets').val(fila.find('td:eq(4)').text());
        $('#edit_txt_offer').val(fila.find('td:eq(5)').text());
        let img=fila.find('td:eq(1)').html();
        $('#edit_img_previa').attr('src',$(img).attr('src')).attr('id_img',$(img).attr('id'));
        $('#modal_edit_product').modal('show');
    });
    
    $('#frm_edit_product').submit(function(event){
        
        event.preventDefault();
        event.stopPropagation();
        if(this.checkValidity()===false){
            this.classList.add('was-validated');
        }
        else{
            let formData = new FormData();
            let p_id=$('#edit_txt_nombre').attr('p_id');
            let p_img=document.getElementById('edit_img_product').files[0];
            let p_name=$('#edit_txt_nombre').val();
            let p_equipments=$('#edit_txt_equipmets').val();
            let p_offer=$('#edit_txt_offer').val();
            
            formData.append('p_id',p_id);
            formData.append('p_name',p_name);
            formData.append('p_equipments',p_equipments);
            formData.append('p_offer',p_offer);
            formData.append('p_img',p_img);
            
            $.ajax({
                url:path_url+'/productos/update_product',
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
                        
                        products.ajax.reload(null, false);
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
                        'El usuario '+formData.username+' no puedo ser actualizado!',
                        'error'
                      );
                }
            });
        }
    });
    // --------------------------------------------------------------
    
    /**
     * Eliminar producto
     */ 
    $(document).on("click", ".delete_product", function(){
        
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
                let p_id=$(this).attr('p_id');
                $.ajax({
                    url:path_url+'/productos/delete_product',
                    type:"POST",
                    dataType:"json",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data:'p_id='+p_id,
                    success:function(response){
                        
                        if(response.error){
                        
                            Swal.fire(
                                'Error!',
                                response.error.message,
                                'error'
                            );
                        }
                        else{
                            
                            products.ajax.reload(null, false);
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
                            'El producto no pudo ser eliminado!',
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
                    'El producto NO fue eliminado',
                    'error'
                );
            }
        });
    });
    // --------------------------------------------------------------
    
    read_products();
});

                        'rgba(54, 162, 235, 0.2)'
                        'rgba(54,162,235,1)'
