<?= $tabla.$link;?>
<script type="text/javascript">
    function update(user){
        
    }
    function deleteu(user){
        
        if(confirm("Esta seguro que desea borrar el usuario "+user+"?")){
            $.ajax({
                type: "POST",
                url: "usuarios/del",
                data: {"usuario":user},
                dataType: "json",
                success: function(data) {
                    //var obj = jQuery.parseJSON(data); if the dataType ==is not specified as json uncomment this
                    // do what ever you want with the server response
                    if(data==1){
                            alert('Usuario borrado'); 
                   $('tr:contains("'+user+'")').eq(0).remove()
                    }
                },
                error: function() {
                    alert('error handing here');
                }
            });
        }
    }
$(function() {
    $( "#dialog" ).dialog({
		autoOpen: false,
		modal: true,
		show: "fold",
		hide: "scale",
		resizable: false,
		open: function() {
			$('.ui-widget-overlay').addClass('custom-overlay');
		},
		close: function() {
			$('.ui-widget-overlay').removeClass('custom-overlay');
		} 
	});
	$('#agregar').click(function(){
		$("#dialog").dialog("open");
	});
        $('#adduser').click(function(){
		                        
                        var datastring = $("input").serialize();
                        
            $.ajax({
                type: "POST",
                url: "usuarios/add",
                data: datastring,
                dataType: "json",
                success: function(data) {
                    //var obj = jQuery.parseJSON(data); if the dataType ==is not specified as json uncomment this
                    // do what ever you want with the server response
                    if(data==1){
                   alert('Usuario creado'); 
                   $("#dialog").dialog("close");
                    }
                },
                error: function() {
                    alert('error handing here');
                }
            });
                        
                        return false;
	});
});
</script>
<div id="pf-form">
	<button type="button" id="agregar">Agregar</button> 
</div>
<div id="dialog">
	<form id="pf-form">
		<div>
			<label for="usuario">Usuario:</label>
                        <input type="text" name="usuario" id="usuario" placeholder="Escribe tu nombre de usuario"></input>
		</div>
            <div> 
			<label for="usuario">Password:</label>
			<input type="text" name="password" id="password" placeholder="Escribe tu nombre de usuario"></input>
		</div>
		<div>
			<label for="nombre">Nombre:</label>
			<input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre"></input>
		</div>
		<div>
			<label for="apepat">Apellido Paterno:</label>
			<input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Escribe tu apellido paterno"></input>
		</div>
		<div>
			<label for="apemat">Apellido Materno:</label>
			<input type="text" name="apellido_materno" id="apellido_materno" placeholder="Escribe tu apellido materno"></input>
		</div>
		<div>
			<label for="email">E-mail:</label>
			<input type="text" name="e-mail"  id="e-mail" placeholder="Escribe tu E-mail"></input>
		</div>
		<div class="button">				
			<button type="submit" id="adduser">Crear Nuevo Usuario</button>
		</div>
	</form>
</div>