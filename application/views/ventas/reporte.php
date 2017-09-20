<script>
     function users() {
            $.post('usuarios/cajausuarios', {fecha: $("#fechainicio").val()},
                    function (data) {
                        var resp = JSON.parse(data);
                        $("#usuarios").html(resp['lista_usuarios']);
                    }
            );
        }
    $(document).ready(function () {
        $("#fechainicio").datepicker({
            dateFormat: "dd-mm-yy"
        });
        $("#fechafin").datepicker({
            dateFormat: "dd-mm-yy"
        });
       users();
        $.post('tickets/tipotickets', {},
                function (data) {
                    var resp = JSON.parse(data);
                    $("#tipos").append(resp['tipos']);
                }
        );
        $.post('ventas/reporte/?page=', {fechainicio: $("#fechainicio").val() + ' 00:00:00', fechafin: $("#fechafin").val() + ' 23:59:59'},
                function (data2) {
                    var resp = JSON.parse(data2);
                    $("#dtabla").html(resp["tabla"]);
                    $("#dlink").html(resp["link"]);
                }
        );

        $("#btnbuscar").click(function () {
            $.post('ventas/reporte', {fechainicio: $("#fechainicio").val() + ' 00:00:00', fechafin: $("#fechafin").val() + ' 23:59:59', usuario: $("#usuarios").val(), tipo: $("#tipos").val(), motivo:  $("#motivo").val() },
                    function (data) {
                        var resp = JSON.parse(data);
                        $("#dtabla").html(resp["tabla"]);
                        $("#dlink").html(resp["link"]);
                    }
            );
        });
        $("#btnpdf").click(function () {
            
            $.post('ventas/exportapdf', {fechainicio: $("#fechainicio").val() + ' 00:00:00', fechafin: $("#fechafin").val() + ' 23:59:59', usuario: $("#usuarios").val(), tipo: $("#tipos").val(), cajas:  $('.radio1:checked').val(), motivo:  $("#motivo").val() },
                    function (data) {
                        window.open(data, '_blank');
                    }
            );
        });
    });
</script>
<div class="pf-contenedor">
    <h1><?php echo $subtitulo; ?></h1>
    <div id="pf-form" name="pf-form">
        <div>
            <label for="codigobarrass">De:</label>
            <input type="text" id="fechainicio" onchange="users()" name="fechainicio" placeholder="Seleccione" value="<?= date('d-m-Y') ?>">
            <label for="codigobarrass">al:</label>
            <input type="text" id="fechafin" name="fechafin" placeholder="Seleccione" value="<?= date('d-m-Y') ?>">
            <label for="codigobarrass">Usuario:</label>
            <select name="usuarios" id="usuarios">
                <option value="" selected>----Select----</option>
            </select>
            <label for="codigobarrass">Tipo Boleto:</label>
            <select name="tipos" id="tipos">
                <option value="" selected>----Select----</option>
            </select>
            <label for="motivo">Motivo DESC/CORTESIA:</label>
              <input  name="motivo" type="text" class='mot' id="motivo" placeholder="NOMBRE/APELLIDO/GRUPO/MOTIVO"/>
            <input type="radio" name="caja" class='radio1' id="caja" value="CAJA 1"> Caja 1
            <input type="radio" name="caja" class='radio1' id="caja" value="CAJA 2"> Caja 2
        </div> 
        <div class="button">				
            <button type="submit" id="btnbuscar">Buscar</button>
            <button type="submit" id="btnpdf">PDF</button>
        </div>
    </div>
    <div id="dtabla"></div>
    <div id="dlink"></div>
</div>