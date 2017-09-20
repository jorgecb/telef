<script>
    function envia(text){
        console.log(text);
        var p=text.split('-');
        $("#codigobarras").val(p[0]);
        $("#btnvalidar").trigger("click");
    }
    $(document).ready(function(){
        $("#btnvalidar").click(function () {            
            window.open('../ventas/printticket?code='+($("#codigobarras").val().trim()), '_blank');
        });
        
       $('#search').click(function(){
             $.post('busca', {token: $("#find").val().trim()},
                            function (data) {
                                console.log(data);
                                  var resp=JSON.parse(data);
                                  console.log(resp);
                                $('#busqueda').html(resp["codes"]);
                            }
                            );
       });
        
    });
</script>
<div class="pf-contenedor">
	<h1><?php echo $subtitulo;?></h1>
	<div id="pf-form" name="pf-form">
		<div style="float:left">
                    <label for="codigobarrass">Motivo Descuento:</label>
			<input type="text" id="find" name="find" placeholder="Escribe cualquier palabra">
			<label for="codigobarrass">Codigo de Barras:</label>
			<input type="text" id="codigobarras" name="codigobarras" placeholder="Escanear C&oacute;digo de Barras">
                        <div class="button">				
                    <button type="button" id="search">Buscar</button>
			<button type="submit" id="btnvalidar">Imprimir</button>
		</div>
                     
		</div>
            <div style="float:left">
                <ul id="busqueda"></ul> 
		</div>
		   
       <form action="printertiket"  method="post" target="_blank">
                    <div style="float:left">	
                        
			                  <input type="text" style="display:none" id="venta" name="codes" value="<?=$last?>" />  
                        <button type="submit" style="float:left" id="print">Imprimir Ultima Venta</button> 
                        </div>
    </form>                    
                      
	</div>
</div>