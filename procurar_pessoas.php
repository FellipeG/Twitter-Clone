<?php

    session_start();

    if (!isset($_SESSION['usuario'])) {
				header('Location: index.php?erro=1');
				die();
		}
		
		require_once('db.class.php');
		
		$objDb = new Db();
		$conn = $objDb->conecta_mysql();

		// Retornar quantidade de Tweets
		$sql = "SELECT COUNT(*) FROM tweet WHERE id_usuario=$_SESSION[id]";
		if ($query = mysqli_query($conn, $sql)) {
			$arr = $query->fetch_array(MYSQLI_NUM);
			$tweets = $arr[0];
		} else {
			echo 'Erro no Select de tweets';
			die();
		}

		// Retornar quantidade de seguidores
		$sql = "SELECT COUNT(*) FROM seguidores WHERE id_seguido=$_SESSION[id]";
		if ($query = mysqli_query($conn, $sql)) {
			$arr = $query->fetch_array(MYSQLI_NUM);
			$seguidores = $arr[0];
		} else {
			echo 'Erro no Select de seguidores';
			die();
		}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone - Procurar pessoas</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">

			$(document).ready(function() {

				$('#btn_procurar_pessoas').click(function() {

					if ($('#nome_pessoa').val().length > 0) {

						$.ajax({
							url: 'get_pessoas.php',
							method: 'post',
							data: $("#nome_pessoa").serialize(), // passando todos os campos de uma vez
							//data: { texto_tweet: $('#nome_pessoa').val() }, // passando valores manualmente
							success: function(data) {
								$('#pessoas').html(data);
								$('.btn_seguir').click(function() {
									var id_usuario = $(this).data('id_usuario');
									
									$.ajax({
										url: 'seguir.php',
										method: 'post',
										data: {'id_seguido' : id_usuario},
										success: function(data) {
											$('#btn_seguir'+id_usuario).hide();
											$('#btn_deixarDeSeguir'+id_usuario).show();
											alert(data);
										}

									});

								});

								$('.btn_deixarDeSeguir').click(function(){

									var id_usuario = $(this).data('id_usuario');

									$.ajax({
										url: 'deixar_seguir.php',
										method: 'post',
										data: {'id_usuario': id_usuario},
										success: function(data) {
											$('#btn_seguir'+id_usuario).show();
											$('#btn_deixarDeSeguir'+id_usuario).hide();
											alert(data);
										}
									});

								});

							}
						});

					}

				});

			});

		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
                <li><a href="home.php">Voltar para home</a></li>
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body">

							<h4><?= $_SESSION['usuario'] ?></h4>
							<hr />

							<div class="col-md-6">
								TWEETS <br /> <?= $tweets ?>
							</div>

							<div class="col-md-6">
								SEGUIDORES <br /> <?= $seguidores ?>
							</div>

						</div>
					</div>
				</div>

	    	<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
							<form id="form_procurar_pessoas" class="input-group">
								<input type="text" class="form-control" name="nome_pessoa" id="nome_pessoa" placeholder="Quem você está procurando?" maxlength="140" />
								<span class="input-group-btn">
									<button class="btn btn-default" id="btn_procurar_pessoas" type="button">Procurar</button>
								</span>
							</form>
						</div>

						<div id="pessoas" class="list-group">

						</div>

					</div>
				</div>

				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body">

						</div>
					</div>
				</div>

			</div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>