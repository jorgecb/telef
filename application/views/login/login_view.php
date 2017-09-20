<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>ComputerSys :: Login</title>
    <!--<script type="text/javascript" src="<?php echo base_url();?>js/demo.js"></script>-->
    <link type='text/css' rel='stylesheet' href="<?php echo base_url();?>css/general.css" />
    <link type='text/css' rel='stylesheet' href="<?php echo base_url();?>css/login.css" />
  </head>
  <body>
    <div id="main">
        <?php echo form_open('verifylogin'); ?>
        <img src="<?php echo base_url();?>css/general/logo.main.jpg" title="ComputerSyS" width="400" height="100">
        <h1>Seguimientos</h1>
        <div class="message"><?php echo validation_errors(); ?></div>
        <div id="login" class="form">
            <div class="field">
              <label for="lu">Folio / Usuario:</label>
              <input type="text" size="20" id="usuario" name="usuario"/>
            </div>
            <div class="field">
              <label for="lc">Cliente /Contrase&ntilde;a:</label>
              <input type="password" size="20" id="passoword" name="password"/>
            </div>
          </div>
          <br/>
          <div class="controls">
            <input type="submit" value="Entrar">
          </div>
        </forfgvbm>
    </div>
  </body>
</html>
