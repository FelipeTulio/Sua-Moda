<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            
			<?php
				if(isset($_GET['estilo']))
				{
					$estilo = $_GET['estilo'];
					
					if($estilo == 'nerd')
					{
						echo "<link href='nerd.css' rel='StyleSheet' type='text/css'>";
					}
					else if($estilo == 'rock')
					{
						echo "<link href='rock.css' rel='StyleSheet' type='text/css'>";
					}
					else
					{
						echo "<link href='jeito.css' rel='StyleSheet' type='text/css'>";
					}
				}
				else
				{
					echo "<link href='jeito.css' rel='StyleSheet' type='text/css'>";
				}
			?>
            <title>Sua Moda</title>
    </head>
    <body class="bodyW">
		
        <div class="div-borda"><!--Principal-->
            <div class="cabecalho"><!--Cabe�alho-->
				<div class="image_title">
					<?php
						//Iniciando a sess�o
						session_start();
						include_once 'connect.php';
						/*if(isset($_SESSION['logado']))*/
						{
							/*Icones para mudar estilo do site*/
							echo "<a href='home.php'><img src='picture/hello.png'></a><br>
							<a href='home.php?estilo=rock'><img src='picture/guitarra.png'></a><br>
							<a href='home.php?estilo=nerd'><img src='picture/android_rosa.png'></a>";
						}
					?>
				</div>
				<div class="pes"><!--Espaco "Pessoal"-->
					<?php
						include("connect.php");
						if(isset($_SESSION['logado']))
						{
							$sql = "SELECT * FROM sis_login WHERE idusuario = ".$_SESSION['id_user'];
							
							$rs = mysql_query($sql);
							if(mysql_num_rows($rs))
							{
								$user = mysql_fetch_array($rs);
								if($user["tipo"]=='a'){header('Location:admin.php');} //admin tem p�gs espec�ficas
								$nome = $user["nome"]; /*nome completo*/
								$foto = $user["foto"];
								
								echo "<table border='0' style='float:right'>
										<tr>
											<td colspan='2'><img src='$foto' width='55px' height='60px'></td>
										</tr>
										<tr>
											<td><a href='user_d_pessoais.php' style='color:black;'>$nome</a></td>
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
            
			<!--***MENU***-->
			<div class='NavbarMenu'>
				<ul id='nav'>
					<?php include_once 'designer.inc'; menu();?>
				</ul>
			</div>
			
            <div class="content"><!--Conte�do-->
			Construindo...
				<?php
					if($user["tipo"]=='u')/*clicou em adicionar produto*/
					{
						echo "<center><a href='user_d_pessoais.php'><div style='width:200px;height:30px;padding-top:5px;background-color:#f8f8ff;float:left;color:red;'>Dados Pessoais</div></a>
							<a href='user_d_endereco.php'><div style='width:200px;height:30px;padding-top:5px;background-color:#f8f8ff;float:left;color:red;'>Dados de Endere�o</div></a>
							<a href='user_d_identificacao.php'><div style='width:200px;height:30px;padding-top:5px;background-color:#f8f8ff;float:left;color:red;'>Dados de Identifica��o</div></a>
							<a href='user_password.php'><div style='width:200px;height:30px;padding-top:5px;background-color:#f8f8ff;float:left;color:red;'>Senha</div></a></center><br>";
											
						if(isset($_POST['atualizar'])) //clicou no bot�o
						{
							$email = $_POST["email"];
							$email2 = $_POST["email2"];
							$senha = $_POST["senha"];
							
							if(!empty($email) && !empty($email2) && !empty($senha)) //verificando campos em branco
							{
								$idusuario = $user['idusuario'];
								//verificar se a senha atual do usu�rio est� correta
								include_once "classe.php";
								$obj = new Classe;
								$sql = "SELECT idusuario, senha FROM sis_login WHERE tipo='u' AND idusuario='$idusuario' AND senha='$senha'";
								$resultado = mysql_query($sql) or die (mysql_error());
								
								if(mysql_num_rows($resultado)) //se estiver certo
								{
									//chamar m�todo de atualizar identificacao
									echo "<br><center style='color:green;'>Dados de identifica��o atualizados!</center>";
								}
								else
								{
									echo "<br><center style='color:red;'>Senha inv�lida!</center>";
								}
								//$resultado = $obj->senha($user['idusuario'], $senha_atual);
							}
							else
							{
								echo "<br><center style='color:red;'>Os campos n�o podem ser nulos!</center>";
							}
						}
						
						$email = $user["email"];
						
						echo "<form method='post' action='user_d_identificacao.php'>
							<br><center>ATUALIZAR&nbsp&nbsp&nbspDADOS&nbsp&nbsp&nbspDE&nbsp&nbsp&nbspIDENTIFICA��O&nbsp?</center>
							<table border=0>
								<tr>
									<td class='tex'>* Email
									<br>* Email novamente
									<br><br>Digite sua senha</td>
									<td class='cai'>
									<input type='text' id='txt' name='email' value='$email'><br>
									<input type='text' id='txt' name='email2' placeholder='Digite novamente o email'>
									<br><br><input type='password' id='txt' name='senha' placeholder='Digite sua senha'></td>
								</tr>
								<tr>
									<td colspan='3'><button name='atualizar'>Atualizar</button></td>
								</tr>
								<tr></tr>
							</table>
						</form>";
					}
					else
					{
						echo "<br><center>� necess�rio est� cadastrado!<br>
							<a href='home.php'>P�gina Inicial</a></center><br>";
					}
				?>
            </div>
			<?php include_once 'designer.inc'; rodape(); ?>
        </div>
    </body>
</html>