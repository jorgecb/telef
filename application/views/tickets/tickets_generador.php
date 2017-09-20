<script>
    $(document).ready(function(){
		$.post('tickets/tipotickets', {},
            function(data){
                var resp=JSON.parse(data);
				$("#tipoticket").append(resp['tipos']);
			}
		);
				
	});
</script>
<div class="pf-contenedor">
	<h1><?php echo $subtitulo;?></h1>
	<?php 
		$attributes = array('target' => '_blank', 'id' => 'pf-form', 'name' => 'pf-form'); 
		echo form_open('tickets/generador',$attributes); 
	?>
			<div>
				<label for="username">Cantidad:</label>
				<input type="number" id="cantidad" name="cantidad" min="1" max="99" value="1">
			</div>
			<div>
				<label for="password">Tipo:</label>
				<select name="tipoticket" id="tipoticket">
				<option value="0" selected>-------------------------Select-----------------------</option>
				</select>
			</div>
			<div class="button">				
				<button type="submit">Generar Ticket(s)</button>
			</div>
		</form>
	<div id="message"></div>
</div>