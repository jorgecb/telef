<?php

$nombre = $_GET['id'];

?>

        <div id="formulario">
            <form id="form" method="post">
                <div class="item">
                    <input type="text" value="<?=$nombre?>" name="nombre" id="nombre" hidden="">
                    <label>Contrasena actual: </label>
                    <input type="password" name="ca" id="ca">
                </div>
                <div class="item">
                    <label>Contrasena nueva:</label>
                    <input type="password" name="cn" id="cn">
                </div>
                <div class="item">
                    <label>Confirma tu contrasena:</label>
                    <input type="password" name="cc" id="cc">       
                </div>
                <div class="item">
                    <button type="submit" id="submit"> Enviar</button>
                </div>
            </form>
        </div>
        <script>
            $(document).ready(function(){
               $( "#form" ).submit(function( event ) {
                   nombre = $('#nombre').val();
                   ca = $('#ca').val();
                   cn = $('#cn').val();
                   cc = $('#cc').val();
                   
                    if(ca!=="" && cn!=="" && cc!==""){
                        var parametros = {
                                "nombre" : nombre,
                                "ca" : ca,
                                "cn" : cn,
                                "cc" : cc
                        };
                        $.ajax({
                                data:  parametros,
                                url:   'Password/update',
                                type:  'post',                        
                                success:  function (response) { 
                                   if(response == 0){
                                       alert("!CORRECTO GRACIAS!");
                                       $('#ca').val("");
                                       $('#cn').val("");
                                       $('#cc').val("");
                                       location.href="home/logout";
                                   }else  if(response == 2){
                                       alert("contrasena actual erronea");
                                   }
                                   else{
                                       alert("Ocurrio un error intente mas tarde");
                                   }
                                }
                        });
                    }
                    else {
                        alert("Por favor llena todos los campos");
                    }
//                alert( "Handler for .submit() called." );
                event.preventDefault(); 
              }); 
            });
        </script>
        <style>
            #formulario{
                margin: 0 auto;
            
                margin-top: 10%;
                width: 43%;
                height: 200px;
                left: 33%;
                top: 30%;
                border-radius: 10px; 
                z-index: 1;
                padding-top: 49px;
                color: white;
                text-align: center;
            }
            #form{
                display: inline-block;
            }
            label{
                display: inline-block;
                width: 120px;
                margin-right: 60px;
            }
            .item{
                margin-bottom: 15px;
            }
            #submit{
                margin-top: 20px;
            }
        </style>
    
