<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <link href="jeito.css" rel="StyleSheet" type="text/css">
			<script type="text/javascript" src="javascript/jquery.js"></script> 
			<script type="text/javascript" src="javascript/cycle2.js"></script>
            <title>Sua Moda</title>
    </head>
    <body class="bodyW">
		
        <div><!--Principal-->
            <div class="cabecalho"><!--Cabe�alho-->
				<a href="home.php" class="image_title"><div class="image_title"></div></a>
				<div class="pes"><!--Espaco "Pessoal"-->
					<?php
						//Iniciando a sess�o
						session_start();
						include("connect.php");
						if(isset($_SESSION['logado']))
						{
							$sql = "SELECT * FROM sis_login WHERE idusuario = ".$_SESSION['id_user'];
							
							$rs = mysql_query($sql);
							if(mysql_num_rows($rs))
							{
								$user = mysql_fetch_array($rs);
								$nome = $user["nome"]; /*nome completo*/
								$foto = $user["foto"];
								
								echo "<table border='0' style='float:right'>
										<tr>
											<td colspan='2'><img src='$foto' width='55px' height='60px'></td>
										</tr>
										<tr>
											<td><a href='user.php' style='color:black;'>$nome</a></td>
											<td><a href='logout.php' style='color:red;'>Sair</a></td>
										</tr>
									  </table>";
							}
						}
						else
						{
							echo "<div><a href='cadastrar.php'>Cadastrar</a></div><br><br>";
							echo "<div><a href='login.php'>Login</a></div>";
						}
					?>
				</div>
            </div>
            <?php include_once 'designer.inc'; menu();?>  <!--***MENU***-->
            <div class="content"><!--Conte�do-->
				<SCRIPT language="JavaScript">
					<!--
					$(function() {  
					$('#galeria').show(); //exibe a div pai  
					$('#galeria').cycle({  
					fx:     'fade',  
					timeout: 3000,  
					speed: 900,  
					next:   '.next',  
					prev:   '.previous',  
					pager: '.numbers'  
					});  
					});
					// -->
				</SCRIPT>
				
				<div id="galeria">
					<div class="imagem">
						<a href="#" title="TITULO"><img src="produtos/blusas.jpg"/></a>
					</div>
					<div class="imagem">
						<a href="#" title="TITULO"><img src="produtos/blusas2.jpg"/></a>
					</div>
				</div>
				
				<!--<div id="navegar">
					<span><a class="previous" href="#">Anterior</a></span>  
					<span><a class="next" href="#">Pr�ximo</a></span>  
				</div>-->
            </div>
			<?php include_once 'designer.inc'; rodape(); ?>
        </div>
    </body>
</html>