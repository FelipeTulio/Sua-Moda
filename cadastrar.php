<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <link href="jeito.css" rel="StyleSheet" type="text/css">
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
								$nome1 = $user["nome"]; /*nome completo*/
								$foto = $user["foto"];
								$nome = "";
								for($cont=0; $nome1[$cont]!=' '; $cont++) /*pegar apenas 1� nome*/
								{
									$nome = $nome.$nome1[$cont]; /* $nome e o 1� nome*/
								}
								echo "<table border='0' style='float:right'>
										<tr>
											<td colspan='2'><img src='$foto' width='80px'></td>
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
				<?php //////////////************CADASTRANDO INCLUSIVE IMAGEM NO BD*********////////////
					// Conex�o com o banco de dados
					$conn = @mysql_connect("localhost", "root", '') or die ("Problemas na conex�o.");
					$db = @mysql_select_db("site", $conn) or die ("Problemas na conex�o.");
					 
					// Se o usu�rio clicou no bot�o cadastrar efetua as a��es
					if (isset($_POST['cadastrar']))
					{
						$verificar_foto = 0;
						// Recupera os dados dos campos
						$nome = $_POST['nome'] ." ". $_POST['sobrenome'];
						$cpf = $_POST['cpf'];
						$telefone = $_POST['telefone'];
						$endereco = $_POST['endereco'];
						$numero = $_POST['numero'];
						$bairro = $_POST['bairro'];
						$cidade = $_POST['cidade'];
						$email = $_POST['email'];
						$password = $_POST['password'];
						$password2 = $_POST['password2'];
						if(isset($_POST['foto'])) {$foto = $_FILES["foto"];}
						else {$verificar_foto++;} /* se tiver diferente de ZERO carrega imagem padr�o*/
						  /*ter� que permitir ao cliente a OP��O de N�O escolher imagem*/
						/*if(!empty($foto["name"])){echo $foto["name"];}
						else {echo "asdf";}*/
						// Se a foto estiver sido selecionada
						if(!empty($nome) && !empty($cpf) && !empty($telefone) && !empty($endereco) && !empty($numero) && !empty($bairro)
							&& !empty($cidade) && !empty($email) && !empty($password) && !empty($password2) && $password==$password2) //(!empty($foto["name"]))
						{
							// Tamanho m�ximo do arquivo em bytes
							$tamanho = 100000;
							
							// Verifica se o tamanho da imagem � maior que o tamanho permitido
							if($foto["size"] > $tamanho && $verificar_foto==0)
							{
								echo "<center>A imagem deve ter no m�ximo ".$tamanho." bytes</center><br>";
							}
							else
							{
								if($verificar_foto==0 && $ext[1] != "jpg" && $ext[1] != "bmp" && $ext[1] != "png" && $ext[1] != "gif" && $ext[1] != "jpg" && $ext[1] != "jpeg")
								{
									// Pega extens�o da imagem4
									preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
									// Verifica se o arquivo � uma imagem
									//if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $foto["type"]))
								   echo "<center>Isso n�o � uma imagem!</center><br>";
								}
								else
								{
									if($verificar_foto==0)
									{
										// Pega as dimens�es da imagem
										$dimensoes = getimagesize($foto["tmp_name"]);
										
										//preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
										//echo "<br>".$ext[1];
										// Gera um nome �nico para a imagem
										$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
							 
										// Caminho de onde ficar� a imagem
										$caminho_imagem = "fotos/" . $nome_imagem;
							 
										// Faz o upload da imagem para seu respectivo caminho
										move_uploaded_file($foto["tmp_name"], $caminho_imagem);
									}
									else
									{
										$caminho_imagem = "fotos/".$foto;
									}
									//echo "INSERT INTO usuarios VALUES (null, \"$nome\", \"$email\", \"$nome_imagem\");";
									// Insere os dados no banco
							////////$sql = mysql_query("INSERT INTO sis_login VALUES (null, \"$nome\", \"$email\", \"$password\", \"$caminho_imagem\");");//\"rog\", \"ema\", \"nom\")");//(null, '".$nome."', '".$email."', '".$nome_imagem."')");
									
									include "classe.php";
									$obj = new Classe; /* usando a fun��o INSERIR do arquivo classe.php */
									$obj->inserir($nome, $cpf, $telefone, $endereco, $numero, $bairro, $cidade, $email, $password, $caminho_imagem);
									echo "<br><center style='color:green;'>Cadastrado com sucesso!</center><br>";
								}
							}
						}
						else
						{//echo "<br><center style='color:red;'>Construindo! Aguarde...</center>";
							echo "<br><center style='color:red;'>Os campos com * n�o podem ficar em branco!</center><br>";
						}
					}
				?>
				<form method="post" action="cadastrar.php" enctype="multipart/form-data">
					<br><center>CADASTRAMENTO</center>
					<table border="0">
						<tr>
							<td colspan="2"><u>Dados de Contato</u></td>
						</tr>
						<tr>
							<td>* Nome</td>
							<td><input type="text" id="txt" name="nome" maxlength="10" placeholder="Digite o 1� nome"></td><!--Limmite de 10 d�gitos neste campo-->
						</tr>
						<tr>
							<td>* Sobrenome</td>
							<td><input type="text" id="txt" name="sobrenome" placeholder="Digite o sobrenome"></td>
						</tr>
						<tr>
							<td>* CPF</td>
							<td><input type="text" id="txt" name="cpf" placeholder="Digite o CPF"></td>
						</tr>
						<tr>
							<td>* Telefone</td>
							<td><input type="text" id="txt" name="telefone" placeholder="Digite o telefone"></td>
						</tr>
						<tr>
							<td colspan="2"><br><u>Dados de Endere�o</u></td>
						</tr>
						<tr>
							<td>* Endere�o</td>
							<td><input type="text" id="txt" name="endereco" placeholder="Digite o endere�o"></td>
						</tr>
						<tr>
							<td>* N�mero</td>
							<td><input type="text" id="txt" name="numero" placeholder="Digite o n�mero"></td>
						</tr>
						<tr>
							<td>* Bairro</td>
							<td><input type="text" id="txt" name="bairro" placeholder="Digite o bairro"></td>
						</tr>
						<tr>
							<td>* Cidade</td>
							<td><input type="text" id="txt" name="cidade" placeholder="Digite a cidade"></td>
						</tr>
						<tr>
							<td colspan="2"><br><u>Dados de Identifica��o</u></td>
						</tr>
						<tr>
							<td>* Email</td>
							<td><input type="text" id="txt" name="email" placeholder="Digite o email"></td>
						</tr>
						<tr>
							<td>* Senha</td>
							<td><input type="password" id="txt" name="password" placeholder="Digite a senha"></td>
						</tr>
						<tr>
							<td>* Confirma��o da Senha</td>
							<td><input type="password" id="txt" name="password2" placeholder="Digite a senha novamente"></td>
						</tr>
						<tr>
							<td>Deseja escolher uma foto?</td>
							<td><input type='radio' name='esc_fot'>Sim</td>
							<td><input type='radio' name='esc_fot'>N�o</td>
						</tr>
						<tr>
							<td>Foto</td>
							<td><input type="file" name="foto"></td>
						</tr>
						<tr>
							<td colspan="2"><br><button name="cadastrar">Cadastrar</button></td>
						</tr>
					</table>
				</form>				
				
				
            </div>
			<?php include_once 'designer.inc'; rodape(); ?>
        </div>
    </body>
</html>