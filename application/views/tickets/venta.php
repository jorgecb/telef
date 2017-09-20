<script>
    // Arguments :
//  verb : 'GET'|'POST'
//  target : an optional opening target (a name, or "_blank"), defaults to "_self"
    
    var grupo = "";
    var push = false;
    open = function (verb, url, data, target) {
        $("#print").remove();
        var form = document.createElement("form");
        form.id = "print";
        form.action = url; 
        form.method = verb;
        form.target = target || "_blank";

        for (i = 0; i < data.length; i++) {
            var input = document.createElement("textarea");
            input.name = "codes[]";
            input.value = data[i];
            form.appendChild(input);

        }
        

        form.style.display = 'none';
        document.body.appendChild(form);
        form.submit();
    };
function changeprice(obj, tipo){
console.log(tipo);
if(tipo=='preventa'||tipo=='postventa'||tipo=='G.Otros'){
 var precio = prompt("introduce el precio nuevo");
console.log( $(obj).parent().parent().parent());
                if (precio != null && precio != "") {
                  
            $(obj).text(accounting.formatMoney(parseFloat(precio.replace(/[^0-9\.]+/g, ""))));
$($(obj).parent().parent().parent()).find("input[type='hidden']").eq(0).val(accounting.formatMoney(parseFloat(precio.replace(/[^0-9\.]+/g, ""))));
                }
}
  Recalcular();
}
//open('POST', 'fileServer.jsp', {request: {key:"42", cols:[2, 3, 34]}});
    var descuentoaplicado = 0;
    function Recalcular() {
        var total = 0;
        descuentoaplicado = false;
        cantidad = $("#tickets tbody").find("tr").length
        if (cantidad === 0) {
            $('#subtotal').text('0.00');
            $('#iva').text('0.00');
            $('#total').text('0.00');
            $('#cambio').text('0.00');
            $('#recibido').val('');
        }

        if($('#recibido').val()==''){
		  	  $('#cambio').text('0.00');
		    }
        $('#tickets tbody tr').each(function () {
            if (Number($(this).find("td input[type='text']").eq(0).val().replace(/[^0-9\.]+/g, "")) != 0 && $(this).find("input[type='hidden']").eq(1).val() == "") {
                var motivo = prompt("Por que el descuento de " + $(this).find("td input[type='text']").eq(0).val());
                if (motivo != null && motivo != "") {
                    $(this).find("input[type='hidden']").eq(1).val(motivo);
                } else
                    $(this).find("td input[type='text']").eq(0).val("0%");

            }

            if (($(this).find("td label").eq(1).text().indexOf("Cortesia") != -1
                    || $(this).find("td label").eq(1).text().indexOf("Empleado") != -1
                    || $(this).find("td label").eq(1).text().indexOf("INAPAM") != -1
                    || $(this).find("td label").eq(1).text().indexOf("Colonos") != -1
                    || $(this).find("td label").eq(1).text().indexOf("G.") != -1
 || $(this).find("td label").eq(1).text().indexOf("preventa") != -1
 || $(this).find("td label").eq(1).text().indexOf("postventa") != -1
                    )

                    && $(this).find("input[type='hidden']").eq(1).val() == "") {
                var motivo = false;
                if ($(this).find("td label").eq(1).text().indexOf("Empleado") != -1) {
                    motivo = prompt("Introduce el Nombre del empleado");
                    if (motivo != null && motivo != "") {
                        $(this).find("input[type='hidden']").eq(1).val(motivo);
                    } else
                        $(this).remove();
                } else if ($(this).find("td label").eq(1).text().indexOf("Colonos") != -1) {
                    motivo = prompt("Introduce el Nombre del Colono");
                    if (motivo != null && motivo != "") {
                        $(this).find("input[type='hidden']").eq(1).val(motivo);
                    } else
                        $(this).remove();
                } else if ($(this).find("td label").eq(1).text().indexOf("G.") != -1) {
                    motivo = prompt("Introduce el Nombre del Grupo", grupo);
                    if (motivo != null && motivo != "") {
                        $(this).find("input[type='hidden']").eq(1).val(motivo);
                        grupo = motivo;

                    } else
                        $(this).remove();
                } else if ($(this).find("td label").eq(1).text().indexOf("preventa") != -1) {
                    motivo = prompt("Comentarios", grupo);
                    if (motivo != null && motivo != "") {
                        $(this).find("input[type='hidden']").eq(1).val(motivo);
                      

                    } else
                        $(this).remove();
                }  else if ($(this).find("td label").eq(1).text().indexOf("postventa") != -1) {

                    motivo = prompt("Comentarios", "comentarios");
                    if (motivo != null && motivo != "") {
                        $(this).find("input[type='hidden']").eq(1).val(motivo);
                     

                    } else
                        $(this).remove();
                } else
                    motivo = prompt("Introduce el motivo");
                if (motivo != null && motivo != "") {
                    $(this).find("input[type='hidden']").eq(1).val(motivo);
                } else
                    $(this).remove();

            }

            $(this).find("td label").eq(2).text(accounting.formatMoney(parseFloat(1 - (Number($(this).find("td input[type='text']").eq(0).val().replace(/[^0-9\.]+/g, "")) / 100)) * Number($(this).find("input[type='hidden']").eq(0).val().replace(/[^0-9\.]+/g, ""))));
            total += Number($(this).find("td label").eq(2).text().replace(/[^0-9\.]+/g, "")) * Number($(this).find("td span").eq(0).text().replace(/[^0-9\.]+/g, ""));
            $(this).find("td span").eq(1).text(accounting.formatMoney(Number($(this).find("td label").eq(2).text().replace(/[^0-9\.]+/g, "")) * Number($(this).find("td span").eq(0).text().replace(/[^0-9\.]+/g, ""))));


            $("#total").text(accounting.formatMoney(total));
            $("#subtotal").text(accounting.formatMoney(parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, ""))) / 1.16));
            $("#iva").text(accounting.formatMoney(parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, ""))) - parseFloat(Number($("#subtotal").text().replace(/[^0-9\.]+/g, "")))));
            if (parseFloat(Number($("#recibido").val().replace(/[^0-9\.]+/g, ""))) != 0)
                $("#cambio").text(accounting.formatMoney(parseFloat(Number($("#recibido").val().replace(/[^0-9\.]+/g, ""))) - parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, "")))));

            if (Number($("#cambio").text().replace(/[^0-9\.]+/g, "")) < 0) {
                $("#cambio").css("color", "red");
            }
        });
        $('#tipoticket').focus();
    }
    function deleterow(id) {
        $('#' + id).remove();
        Recalcular();
    }
    $(document).ready(function () {
        $('#tipoticket').focus();
        $('.inputs').keydown(function (e) {
            if (e.keyCode === 115) {
                $('#recibido').focus();
            }
            if (e.which === 13) {
                if ($(this).attr("id") == "tipoticket") {
                    $('#btngenerar').trigger("click");
                    return false;
                }
                var index = $('.inputs').index(this) + 1;
                $('.inputs').eq(index).focus();
                $('.inputs').eq(index).select();

            }

        });
        $("#codigobarrasint").keyup(function (e) {
            if (e.keyCode == 13) {  //el 13 es enter
                var existe = true;
                $('#tickets tbody tr').each(function () {
                    var cb = $(this).find("td").eq(0).html();
                    if (cb.indexOf($("#codigobarrasint").val()) != -1)
                        existe = false;
                });
                if (existe) {
                    $.post('verificacb', {codigobarras: $("#codigobarrasint").val()},
                            function (data) {
                                var resp = JSON.parse(data);
                                if (resp["result"]) {
                                    $('#tickets tbody:last').append('<tr>' +
                                            '<td><div id="tdlbl"><label id="codigobarras" name="codigobarras"></label></div></td>' +
                                            '<td><div id="tdlbl"><label name="tipo" id="tipo"></label></div></td>' +
                                            '<td><div id="tdlbl"><input type="text" name="descuento" id="descuento"></input></div></td>' +
                                            '<td><div id="tdlbl"><label onclick="changeprice(this)" name="subtotalticket" id="subtotalticket"></label></div></td><input type="hidden" name="subtotalticketreal" id="subtotalticketreal"></input>' +
                                            '</tr>');
                                    $("#codigobarras").text($("#codigobarrasint").val());
                                    $("#tipo").text(resp ['tipo']);
                                    $("#descuento").val(resp ['descuento']);
                                    $("#subtotalticket").text(accounting.formatMoney(resp ['subtotal']));
                                    $("#subtotalticketreal").val(accounting.formatMoney(resp ['subtotal']));
                                    $("#descuento").blur(function () {
                                        Recalcular();
                                    });
                                    $("#total").text(accounting.formatMoney(parseFloat(Number($("#subtotalticket").text().replace(/[^0-9\.]+/g, ""))) + parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, "")))));
                                    $("#subtotal").text(accounting.formatMoney(parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, ""))) * .84));
                                    $("#iva").text(accounting.formatMoney(parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, ""))) * .16));
                                    $("#codigobarras").attr('id', 'codigobarras.');
                                    $("#tipo").attr('id', 'tipo.');
                                    $("#descuento").attr('id', 'descuento.');
                                    $("#subtotalticket").attr('id', 'subtotalticket.');
                                    $("#subtotalticketreal").attr('id', 'subtotalticketreal.');
                                    $("#codigobarrasint").val('');
                                } else
                                    alert(resp["mensaje"]);
                            }
                    );
                } else
                    alert("El codigo de barras ya se encuentra agregado a la lista");
            }

        });



        $("#btnventa").click(function () {
            document.getElementById("btnventa").disabled = true;
            var exitosa = true;


            if ($('#recibido').val() < Number($("#total").text().replace(/[^0-9\.]+/g, ""))) {
                alert("La cantidad cobrada es menor a la cantidad total");
                document.getElementById("btnventa").disabled = false;
                return false;
            }
            if ($('#formapago').val() != 0) {
                push = true;
                 cantidad = $("#tickets tbody").find("tr").length;
                  if (cantidad==0) {
                alert("No hay nada que vender");
              document.getElementById("btnventa").disabled = false;
                return false;
            }
                $.post('generarventa', {cambio: Number($("#cambio").text().replace(/[^0-9\.]+/g, "")), subtotal: Number($("#subtotal").text().replace(/[^0-9\.]+/g, "")), iva: Number($("#iva").text().replace(/[^0-9\.]+/g, "")), total: Number($("#total").text().replace(/[^0-9\.]+/g, "")), formapago: $('#formapago').val()},
                        function (data) {
                            if (data != 0) {
                                cantidad = $("#tickets tbody").find("tr").length;
                                var codes = [cantidad];
                                var indice=-1;
                                $('#tickets tbody tr').each(function (i, val) {
                                     var code = $(this).find("td label").eq(0).text();
                                    $.post('agregadetalle', {folio: data, codigobarras: $(this).find("td label").eq(0).text(), descuento: Number($(this).find("td input[type='text']").eq(0).val().replace(/[^0-9\.]+/g, "")), subtotal: Number($(this).find("td span").eq(1).text().replace(/[^0-9\.]+/g, "")), motivodescuento: $(this).find("input[type='hidden']").eq(1).val()},
                                            function (data2) {    
                                                  indice++;
                                                cantidad = $("#tickets tbody").find("tr").length; 
                                                 codes[indice] = code;
                                               
                                                if (!data2)
                                                    exitosa = false;
                                                if (indice == (cantidad-1)) {
                                                    if (exitosa) { 
                                                        if (codes.length > 0) {
                                                         
                                                            console.log(codes);
                                                             open('POST', 'printertiket', codes, "_blank");
                                                            push = false;
                                                        }
                                                        
                                                        alert("La venta ha sido realizada");
                                                        $('#tickets tbody').html('');
                                                        $('#subtotal').text('0.00');
                                                        $('#iva').text('0.00');
                                                        $('#total').text('0.00');
                                                       // $('#cambio').text('0.00');
                                                        $('#recibido').val('');
                                                        $('#codigobarrasint').focus();
                                                        $('#formapago').val(1);
                                                        $('#tipoticket').val(0);
                                                        $('#pases').val(1);
                                                        $('#tipoticket').focus();
                                                        document.getElementById("btnventa").disabled = false;
                                                    } else
                                                        alert("Ha ocurrido un error");
                                                    document.getElementById("btnventa").disabled = false;
                                                }

                                            }
                                    );
                                });
                            } else {
                                alert("Ocurrio un error");
                                exitosa = false;
                                push = false;
                            }
                        }
                );


            } else {
                alert("Seleccione una forma de pago");
                document.getElementById("btnventa").disabled = false;
            } 
        });
        $.post('tipotickets', {},
                function (data) {
                    var resp = JSON.parse(data);
                    $("#tipoticket").append(resp['tipos']);
                }
        );
        $.post('listaformapago', {},
                function (data) {
                    var resp = JSON.parse(data);
                    $("#formapago").append(resp['lista_formapago']);
                }
        );
        $("#formapago").change(function (e) {
            if ($(this).val() != 1) {

            }
        });
 $("#pases").change(function (e) {
	 var sel=$("#tipoticket :selected").text();
          if(sel.indexOf("red")!=-1 && $("#pases").val()>49){
		alert("solo se permiten 49 Pax en boletos redondos");
		$("#pases").val(49);
		}else if(sel.indexOf("red")==-1 && $("#pases").val()>99){
alert("solo se permiten 99 Pax en boletos secillos");
		$("#pases").val(99);
		}
        });
        $("#recibido").keyup(function (e) {
            $("#recibido").val(parseFloat(Number($("#recibido").val().replace(/[^0-9\.]+/g, ""))));
            $("#cambio").text(accounting.formatMoney(parseFloat(Number($("#recibido").val().replace(/[^0-9\.]+/g, ""))) - parseFloat(Number($("#total").text().replace(/[^0-9\.]+/g, "")))));
            if (Number($("#cambio").text().replace(/[^0-9-\.]+/g, "")) < 0) {
                $("#cambio").css("color", "red");
            } else
                $("#cambio").css("color", "green");
        });

        $("#btncrear").click(function () {
            $("#formnuevo").css('display', 'block');
            $("#crear").css('display', 'none');
        });
        $("#btngenerar").click(function () {
            if($("#pases").val()<=0){
                alert("Numero de personas debe ser mayor a 0");
                return false;
                
        }
            
            $.post('../ventas/generaticket', {tipoticket: $("#tipoticket").val(), pases: $("#pases").val()},
                    function (data) {
                        var resp = JSON.parse(data)
                        cantidad = $("#tickets tbody").find("tr").length;
                        $('#tickets tbody:last').append('<tr id="fila' + cantidad + '">' +
                                '<td><div id="tdlbl"><label id="codigobarras" name="codigobarras">' + resp ['codigobarras'] + '</label></div></td>' +
                                '<td><div id="tdlbl"><label name="tipo" id="tipo">' + resp ['tipo'] + '</label></div></td>' +
                                '<td><div id="tdlbl"><span name="pases" id="pases">' + resp ['open'] + '</span></div></td>' +
                                '<td><div id="tdlbl"><input type="text"  ' + ((resp ['tipo'] == 'Empleado' || resp ['tipo'] == 'Cortesia') ? 'readonly="true"' : "") + '  name="descuento" onblur="Recalcular()"  id="descuento" value="0%"  ></input></div></td>' +
                                '<td><div id="tdlbl"><label name="subtotalticket" onclick="changeprice(this,\''+resp ['tipo']+'\')" id="subtotalticket" >' + resp ['subtotal'] + '</label><input type="hidden" name="subtotalticketreal" id="subtotalticketreal" value="' + resp ['subtotal'] + '"></input> <input type="hidden" name="motivo" id="motivo" value=""></input></div></td>'
                                + '<td><div id="tdlbl"><span>' + resp ['subtotal'] + '</span></td><td><div id="tdlbl" ><img src="../img/eliminar.png" width="30" onclick="deleterow(\'fila' + cantidad + '\')" style="cursor:pointer"></td></tr>');

                        Recalcular();
                        $("#pases").val(1);
                        document.getElementById("btnventa").disabled = false;
                        //window.open('../ventas/vistaticket?code='+(resp ['codigobarras']), '_blank');
                        //$("#formnuevo").css('display','none');
                    }
            );
        });
    });
</script>
<div class="pf-contenedor ventas">
    <div class="button" id="crear">
        <button type="submit" id="btncrear">Vender anterior</button>
    </div>
    <div id="pf-form" name="pf-form">

        <div class="content">
            <div class="tipoven">
                <div style="display:none;" id="formnuevo">
                    <label for="codigobarrass">Codigo de Barras:</label>
                    <input type="text" id="codigobarrasint" name="codigobarrasint" placeholder="Escanear C&oacute;digo de Barras">
                </div>
                <div>
                    <select name="tipoticket" size="19" id="tipoticket" class='inputs'>
                        <option value="0" selected>-----------Select-----------</option>
                    </select>
                </div>
                <div>
                    <label for="descuento">Numero de Pases:</label>
                    <input type="number" id="pases" name="pases" min="1" class='inputs' max="99" value="1">
                </div>
                <div class="button">
                    <button type="submit" class='inputs' id="btngenerar">Agregar</button>
                </div>
            </div>
            <table id="tickets"> 
                <thead>
                    <tr>
                        <th>Codigo de barras</th>
                        <th>Tipo</th>
                        <th>Pases</th>
                        <th>Descuento</th>
                        <th>Costo</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="totales">
                <div class="block">
                    <select name="formapago" id="formapago" class='inputs'>
                    </select>
                </div>
                <input type="text" id="recibido"  name="recibido" class='inputs' placeholder="Cantidad Recibida"></br></br>
                <label>Subtotal: </label><label name="subtotal" id="subtotal" class="cant">0.00</label></br>
                <label>IVA: </label><label name="iva" id="iva">0.00</label></br>
                <label>Total: </label><label name="total" id="total">0.00</label></br></br>
                <label>Cambio: </label><label name="cambio" id="cambio">0.00</label></br></br>
                <div class="button">				
                    <button type="submit" id="btnventa" class='inputs'>Generar Venta</button>
                </div>
            </div>
        </div>
    </div>
</div>
