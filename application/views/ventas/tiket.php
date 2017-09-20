<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html> 
    <head>
        <meta charset="ISO-8859-1">
        <title></title>
        <script>
            function printer(){
                window.print();
                window.close();
             }
            </script>
            <style>
                *{
                    font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
                }
            </style>
    </head>
    <body > 
        <div style="width: 300px; ">
            <h6 style="text-align: right;"><?=date("d/m/Y h:i:s")?></h6>

        <h4>TELEFERICO TAXCO</h4>   
  
         <?php 
         if($conta==0){?>
        Boleto valido para <?=($redondo==1)?$pases/2:$pases?> acceso<?=($pases==1)?"":"s"?> <?=($redondo==1)?"redondo":"sencillo"?><?=($pases==1)?"":"s"?>
        <br/>
        <img src="../ventas/vistaticket?code=<?=$code?>" alt="" />
        Este boleto quedara inservible 
        despues de <?=$horas?> Horas
        </div>
        
        <script>
            printer();
            </script>
 <?php } else echo "este boleto ya fue utilizado no se puede reimprimir"?>

    </body>
</html>
