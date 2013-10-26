<!DOCTYPE html>
	<html lang="es">
		<head>
			<title>.:: Error: Metodo <?php echo $Parametros['URL'][2]; ?> Definido como Protected &#243; Private ::.</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<?php echo NeuralScriptAdministrador::OrganizarScript(array('CSS' => array('BOOSTRAP', 'RESPONSIVE', 'DOCS'))); ?>
		</head>
		<body data-spy="scroll" data-target=".bs-docs-sidebar">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="brand" style="color: white;">Error de Aplicaci&#243;n</a>
						<div class="nav-collapse collapse"></div>
					</div>
				</div>
				<header class="jumbotron subhead" id="overview">
  					<div class="container">
						<h2>Metodo <?php echo $Parametros['URL'][2]; ?> Definido como Protected &#243; Private</h2>
						<p class="lead">Modulo: <?php echo rtrim($Parametros['Modulo'], '/'); ?><br />Controlador: <?php echo $Parametros['URL'][1]; ?>.php<br />Metodo: <?php echo $Parametros['URL'][2]; ?></p>
					</div>
				</header>

				<div class="container">
					<div class="row">
						<div class="span9">
							<section id="Inicio">
							<div class="alert alert-error">
								<p class="lead">
									Actualmente el Metodo <strong><?php echo $Parametros['URL'][2]; ?></strong> no es accesible por la ruta: <br />
									<?php echo __NeuralUrlRoot__.$Parametros['URL'][0].'/'.$Parametros['URL'][1].'/'.$Parametros['URL'][2]; ?> <br />
									Este metodo se encuentra definido como Protected &#243; Private. 
								</p>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>