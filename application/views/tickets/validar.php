<script>
    $(document).ready(function(){
        $("#btnCancel").click(function () {
           
         if (confirm (String.fromCharCode(191)+"Eliminar tiket de la venta? Esta accion no puede deshacerce"))
                        {
							var motivo=prompt("Por que va a eliminar este tiket");
							if(motivo!=null && motivo!=""){
                            $.post('delete', {codigobarras : $("#codigobarras").val(),motivo: motivo},
                                function(data2){
                                    if(data2){
                                        alert("Venta Eliminada");
                                        $("#codigobarras").val("");
                                    }
                                    else
                                        alert("Hubo un error al cambiar estatus");
                                }
                            );
							}
                        }
        });
        
        $("#btnvalidar").click(function () {
            $.post('validacb', {codigobarras : $("#codigobarras").val()},
                function(data){
					alert (data);
                    /*var resp=JSON.parse(data);
                    if (resp["result"]){
                        if (confirm ("Ticket valido, "+String.fromCharCode(191)+"Confirmas la entrada?"))
                        {
                            $.post('cambiavencido', {codigobarras : $("#codigobarras").val()},
                                function(data2){
                                    if(data2){
                                        alert("EXITO");
                                        $("#codigobarras").val("");
                                    }
                                    else
                                        alert("Hubo un error al cambiar estatus");
                                }
                            );
                        }
                    }
                    else
                        alert(resp["mensaje"]);*/
                }
            );

        });
    });
</script>
<div class="pf-contenedor">
	<h1><?php echo $subtitulo;?></h1>
	<div id="pf-form" name="pf-form">
		<div>
			<label for="codigobarrass">Codigo de Barras:</label>
			<input type="text" id="codigobarras" name="codigobarras" placeholder="Escanear C&oacute;digo de Barras">
		</div>
		<div class="button"> 
                    	<?php if($rol == 1 || $rol == 2){  ?>
                    <button type="button" id="btnCancel">Cancelar venta</button>
                        <?php }?>
			<button type="submit" id="btnvalidar">Validar</button>
		</div>
	</div>
</div>