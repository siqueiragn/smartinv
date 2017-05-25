<?php
require '../php/db/DB.class.php';
$db = new DB();
extract($_REQUEST);

if(isset($del)){
	$dados[0] = $del;
	$db->execute("DELETE FROM memoria WHERE id_memoria=?",$dados);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memórias</title>
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
      <h3 class="navbar-left"> <a href="#" id="lnk"> Componentes </a> > <a href="#" id="lnk"> Memorias </a> >  <a href="#" id="lnk"> <span class="glyphicon glyphicon-plus" </span> </a> </h3>
      <div class="navbar-right">
      <input type="text" name="searchbox"> <a href<span class="glyphicon glyphicon-search"></span></a>
      </div>
      </div>
    </div>

    <div class="container">
        <div class="col-md-12">
     
		 <table class="table table-striped">
		 <th class="warning">ID</th>
		 <th class="warning">Nome</th>
		 <th class="warning">Frequência</th>
		 <th class="warning">Descrição</th>
		 <th class="warning">Editar</th>
		 <th class="warning wrapper">Remover</th>
<?php 
$result = $db->query("SELECT * FROM memoria");
foreach ($result as $element) {
?>
<tr>
  <td class="active"><?= $element['id_memoria']?></td>
  <td contenteditable="true" class="active"><?= $element['nome']?></td>
  <td contenteditable="true" class="active"><?= $element['frequencia']?></td>
  <td contenteditable="true" class="active"><?= $element['descricao']?></td>
  <td class="active"><a id="lnk" href="#"><span class="glyphicon glyphicon-pencil wrapper"></span></a></td> 
  <td class="active"><a id="lnk" onclick="window.confirm('Confirmar a exclusão final?')" href="?del=<?=$element['id_memoria']?>"><span class="glyphicon glyphicon-remove wrapper"></span></a></td>
</tr>
<?php } ?>
</table>

        </div>
              

      <hr>

      <footer>
        <p>&copy;  Gabriel Nunes de Siqueira - SMARTINV, 2017.</p>
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
