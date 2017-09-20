<!DOCTYPE html>
<html>

<head>
  <title><?php echo $titutlo;?></title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />

  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style_templete.css">
  <script type="text/javascript" src="<?php echo base_url();?>js/modernizr-1.5.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>js/accounting.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>css/jquery.css">
  <script src="<?php echo base_url();?>js/ui.js"></script>
</head>

<body>
  <div id="main">
    <header>
		<div id="banner">
			<div id="welcome" style="float:left";>
				<h3>Teleferico <span>Taxco</span></h3>
			</div><!--close welcome-->

			<div style="float:right; color: whitesmoke;">
			<?php echo $nombre;?><br/>
                           <a style="color: whitesmoke;" href="<?php echo base_url();?>Password?id=<?php echo $usuario?>">CAMBIAR PASSWORD</a>
			</div>
                </div><!--close banner-->
    </header>

	<nav>
		<div id="menubar">
			<ul id="nav">
				<?php 
 					if($rol == 1 || $rol == 2|| $rol == 4){ ?>
						<li <?php if($menu == 'generador') echo 'class="current"';?>><a href="<?php echo base_url();?>tickets/borrados">Cancelados</a></li>
				 <li <?php if($menu == 'reporte') echo 'class="current"';?>><a href="<?php echo base_url();?>ventas">Reporte</a></li>
                                 <li <?php if($menu == 'tickets') echo 'class="current"';?>><a href="<?php echo base_url();?>tickets/reporte">Accesos</a></li>
                                
				<?php 
					} 
				?>
				<li <?php if($menu == 'venta') echo 'class="current"';?>><a href="<?php echo base_url();?>tickets/venta">Venta</a></li>
				
				<li <?php if($menu == 'validar') echo 'class="current"';?>><a href="<?php echo base_url();?>tickets/validar">Validar</a></li>
                                <li <?php if($menu == 'reimprimir') echo 'class="current"';?>><a href="<?php echo base_url();?>tickets/reimprimir">Reimprimir</a></li>
				<?php 
					if($rol == 1 || $rol == 2){ ?>
						<li <?php if($menu == 'usuarios') echo 'class="current"';?>><a href="<?php echo base_url();?>usuarios">Usuarios</a></li>
						<li <?php if($menu == 'precios') echo 'class="current"';?>><a href="<?php echo base_url();?>precios">Precios</a></li>
				<?php 
					} 
				?>
				
				<li><a href="<?php echo base_url();?>home/logout">Salir</a></li>
			</ul>
		</div><!--close menubar-->
    </nav>

	<div id="site_content">
