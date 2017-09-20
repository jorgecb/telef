</div><!--close site_content-->
  </div><!--close main-->

    <footer>
		<?php 
			if($rol == 1 || $rol == 2){ ?>
				<a href="<?php echo base_url();?>tickets">Generador</a> | 
		<?php 
			} 
		?>
		<a href="<?php echo base_url();?>tickets/venta">Venta</a> | 
		<a href="<?php echo base_url();?>tickets/validar">Validar</a> |
		<?php 
			if($rol == 1){ ?>	   
				<a href="projects.html">Tickets</a> | 
				<a href="<?php echo base_url();?>usuarios">Usuarios</a> | 
				<a href="<?php echo base_url();?>precios">Precios</a> | 
				<a href="projects.html">Bit&aacute;cora</a>
		<?php 
			} 
		?>
		<?php 
			if($rol == 1 || $rol == 2){ ?>
				<a href="<?php echo base_url();?>ventas">Reporte</a> | 
		<?php 
			} 
		?>
		<br/><br/>Desarrollado por <a href="http://twitter.com/dajevtg">GOMY&Jorge dev</a>,
		Taxco Guerrero. Copyright &copy 2015 <a href="http://www.montetaxco.mx/">Monte Taxco</a>
    </footer>

  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="<?php echo base_url();?>js/image_slide.js"></script>

</body>
</html>