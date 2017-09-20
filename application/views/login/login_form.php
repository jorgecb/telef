<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Teleferico Taxco</title>




        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">




  </head>

  <body>

    <div class="wrapper">
	<div class="container">
		<h1>Bienvenido</h1>
        <div class="message"><?php echo validation_errors(); ?></div>
		<?php echo form_open('verifylogin'); ?>
			<input type="text" id="usuario" name="usuario" placeholder="Usuario">
			<input type="password" id="password" name="password" placeholder="Contrase&ntilde;a">
			<button type="submit" id="login-button">Iniciar Sesi&oacute;n</button>
		</form>
	</div>

	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <!--<script src="<?php echo base_url();?>js/index.js"></script>-->




  </body>
</html>
