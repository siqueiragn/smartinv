<?php
require 'db/DB.class.php';
$db = new DB();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TITULO</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
  	<link href="../css/custom.css" rel="stylesheet">
  	<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
      <a id="logotitle" class="wrapper" href="#"> SmartInv </a> 
      </div>
    </nav>
    <div class="jumbotron">
      <div class="container">
      <h3> <a href="#"> Inicio</a> > <a href="#"> DIR 2 </a> > <a href="#"> DIR 3 </a> </h3>
      </div>
    </div>

    <div class="container">
        <div class="col-md-12">
          <h2>Heading</h2>
          <!-- On rows -->

		 <table class="table table-striped">
		 <th class="warning">ID</th>
		 <th class="warning">Nome</th>
		 <th class="warning">Frequ�ncia</th>
		 <th class="warning">Descri��o</th>
<?php 
$result = $db->query("SELECT * FROM memoria");
foreach ($result as $element) {
?>
<tr>
  <td class="active"><?= $element['id_memoria']?></td>
  <td class="active"><?= $element['nome']?></td>
  <td class="active"><?= $element['frequencia']?></td>
  <td class="active"><?= $element['descricao']?></td>
</tr>
<?php } ?>
</table>

        </div>
              

      <hr>

      <footer>
        <p>&copy; Gabriel Nunes de Siqueira - SMARTINV, 2017.</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
