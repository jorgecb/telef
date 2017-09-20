<script>
    $(document).ready(function(){
        $("#codigobarrasint").keyup(function (e) {
            if (e.keyCode == 13) {  //el 13 es enter
                var existe = true;
                $('#tickets tbody tr').each(function () {
                    var cb = $(this).find("td").eq(0).html();
                    if (cb.indexOf($("#codigobarrasint").val()) != -1)
                        existe = false;
                });
                if (existe){
                    $.post('verificacb', {codigobarras : $("#codigobarrasint").val()},
                        function(data){
                            var resp=JSON.parse(data);
                            console.log(resp); 
                            if(resp["result"]){
                                $('#tickets tbody:last').append('<tr>'+
                                '<td><div id="tdlbl"><label id="codigobarras" name="codigobarras"></label></div></td>'+
                                '<td><div id="tdlbl"><label name="tipo" id="tipo"></label></div></td>'+
                                '<td><div id="tdlbl"><label name="descuento" id="descuento"></label></div></td>'+
                                '<td><div id="tdlbl"><label name="subtotalticket" id="subtotalticket"></label></div></td>'+
                                    '</tr>');
                                $("#codigobarras").text($("#codigobarrasint").val());
                                $("#tipo").text(resp ['tipo']);
                                $("#descuento").text(resp ['descuento']);
                                $("#subtotalticket").text(accounting.formatMoney(resp ['subtotal']-(resp ['subtotal']*.16)));
                                $("#subtotal").text(accounting.formatMoney(parseFloat(Number($("#subtotal").text().replace(/[^0-9\.]+/g,""))) + parseFloat(Number($("#subtotalticket").text().replace(/[^0-9\.]+/g,"")))));
                                $("#iva").text(accounting.formatMoney(parseFloat(Number($("#iva").text().replace(/[^0-9\.]+/g,""))) + (parseFloat(Number($("#subtotalticket").text().replace(/[^0-9\.]+/g,"")))*.16)));
                                $("#total").text(accounting.formatMoney(parseFloat(Number($("#subtotal").text().replace(/[^0-9\.]+/g,"")))));
                                $("#codigobarras").attr('id','codigobarras.');
                                $("#tipo").attr('id','tipo.');
                                $("#descuento").attr('id','descuento.');
                                $("#subtotalticket").attr('id','subtotalticket.');
								$("#codigobarrasint").val('');
                            }
                            else
                                alert(resp["mensaje"]);
                        }
                    );
                }
                else
                    alert ("El codigo de barras ya se encuentra agregado a la lista");
            }
        });
        $("#btnventa").click(function () {
            $("#cambio").text(accounting.formatMoney(parseFloat(Number($("#recibido").val().replace(/[^0-9\.]+/g,""))) - parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g,"")))));
            $.post('generarventa', {cambio : Number($("#cambio").text().replace(/[^0-9\.]+/g,"")), subtotal : Number($("#subtotal").text().replace(/[^0-9\.]+/g,"")), iva : Number($("#iva").text().replace(/[^0-9\.]+/g,"")), total :  Number($("#total").text().replace(/[^0-9\.]+/g,""))},
                function (data){
                    if (data != 0){
                        $('#tickets tbody tr').each(function () {
                        $.post('agregadetalle', {folio : data, codigobarras : $(this).find("td label").eq(0).text(), subtotal : Number($(this).find("td label").eq(3).text().replace(/[^0-9\.]+/g,""))},
                            function (data2){
                                if (data2)
                                 //   alert("Todo va correctamente");
                                else
                                    alert("Ha ocurrido un error");
                            }
                       );
                       });
                    }
                    else
                        alert("Ocurrio un error");
                }
            );
        });
		$.post('tipotickets', {},
            function(data){
                var resp=JSON.parse(data);
				$("#tipoticket").append(resp['tipos']);
			}
		);
		$("#btncrear").click(function () {
			$("#formnuevo").css('display','block');
			$("#crear").css('display','none');
		});
		$("#btngenerar").click(function () {
			$.post('../ventas/generaticket', {tipoticket: $("#tipoticket").val(), descuento: $("#desc").val()},
				function(data){
					var resp=JSON.parse(data)
					$('#tickets tbody:last').append('<tr>'+
					'<td><div id="tdlbl"><label id="codigobarras" name="codigobarras"></label></div></td>'+
					'<td><div id="tdlbl"><label name="tipo" id="tipo"></label></div></td>'+
					'<td><div id="tdlbl"><label name="descuento" id="descuento"></label></div></td>'+
					'<td><div id="tdlbl"><label name="subtotalticket" id="subtotalticket"></label></div></td>'+
						'</tr>');
					$("#codigobarras").text(resp ['codigobarras']);
					$("#tipo").text(resp ['tipo']);
					$("#descuento").text(resp ['descuento']);
					$("#subtotalticket").text(resp ['subtotal']);
					$("#subtotal").text(accounting.formatMoney(parseFloat(Number($("#subtotal").text().replace(/[^0-9\.]+/g,""))) + parseFloat(Number($("#subtotalticket").text().replace(/[^0-9\.]+/g,"")))));
					$("#iva").text(accounting.formatMoney(parseFloat(Number($("#iva").text().replace(/[^0-9\.]+/g,""))) + (parseFloat(Number($("#subtotalticket").text().replace(/[^0-9\.]+/g,"")))*.16)));
					$("#total").text(accounting.formatMoney(parseFloat(Number($("#subtotal").text().replace(/[^0-9\.]+/g,""))) ));
					$("#codigobarras").attr('id','codigobarras.');
					$("#tipo").attr('id','tipo.');
					$("#descuento").attr('id','descuento.');
					$("#subtotalticket").attr('id','subtotalticket.');
					$("#codigobarrasint").val('');
					window.open('../ventas/vistaticket?code='+(resp ['codigobarras']), '_blank');
					$("#formnuevo").css('display','none');
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
			<input type="text" id="codigobarrasint" name="codigobarrasint" placeholder="Escanear C&oacute;digo de Barras">
		</div>
		<div class="button" id="crear">
			<button type="submit" id="btncrear">Crear Nuevo Ticket</button>
		</div>
		<div style="display:none;" id="formnuevo">
			<div>
				<label for="tipo">Tipo:</label>
				<select name="tipoticket" id="tipoticket">
				<option value="0" selected>-------------------------Select-----------------------</option>
				</select>
			</div>
			<div>
				<label for="descuento">Descuento:</label>
				<input type="number" id="desc" name="desc" min="0" max="99" value="0">
			</div>
			<div class="button">
				<button type="submit" id="btngenerar">Generar Ticket</button>
			</div>
		</div>
		<table id="tickets">
			<thead>
				<tr>
					<th>Codigo de barras</th>
					<th>Tipo</th>
					<th>Descuento</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody> 
			</tbody>
		</table>
		<div id="totales">
			<label>Recibido: </label><input type="text" id="recibido" name="recibido" placeholder="Cantidad Recibida"></br></br>
			<label>Subtotal: </label><label name="subtotal" id="subtotal" class="cant">0.00</label></br>
			<label>IVA: </label><label name="iva" id="iva" style="display: none">0.00</label></br>
			<label>Total: </label><label name="total" id="total">0.00</label></br></br>
			<label>Cambio: </label><label name="cambio" id="cambio">0.00</label></br></br>
		</div>
		<div class="button">				
			<button type="submit" id="btnventa">Generar Venta</button>
		</div>
	</div>
</div>