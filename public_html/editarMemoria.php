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
    <link href="/css/bootstrap.min.css" rel="stylesheet">
  	<link href="/css/custom.css" rel="stylesheet">
  	<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        
        <div class="navbar-header">
        <a id="logotitle"  href="#"> SmartInv </a>
        </div>        
<ul class="nav nav-tabs navbar-right" style="border: none; padding-top: 10px;">
  <li role="presentation" class="active"><a href="#">Home</a></li>
  <li role="presentation"><a href="/memoria.php">Componentes</a></li>
  <li role="presentation"><a href="#">Alguma coisa</a></li>
  <li role="presentation"><a href="#">Outra coisa</a></li>
  <li role="presentation"><a href="#">Ajuda</a></li>
  <li role="presentation"><a href="#">Mais coisa</a></li>
</ul>
      </div>
    </nav>
    <div class="jumbotron">
      <div class="container">
      <h3 class="navbar-left"> <a href="#" id="lnk"> Componentes </a> > <a href="#" id="lnk"> Memorias </a> >  <a href="#" id="lnk"> <?php echo "20"?> </a> </h3>
      </div>
    </div>

    <div class="container">
  

<?php 
//$result = $db->query("SELECT * FROM memoria WHERE id_memoria = ", ); // ARRUMAR AQUI
//foreach ($result as $element) {
?>
<div class="col-md-4 col-xs-4"></div>
<div class="col-md-4 col-xs-4">
<form method="POST" action=#">


<div class="input-group spacerform">
  <span class="input-group-addon">Nome</span>
  <input type="text" class="form-control" name="nome">
</div>

<div class="input-group spacerform">
   <span class="input-group-addon">Frequência</span>
  <input type="text" class="form-control" name="frequencia">
 
</div>

<div class="input-group spacerform">
  <span class="input-group-addon">Descrição</span>
  <input type="text" class="form-control" name="descricao">
</div>

<div class="wrapper" style="padding-top: 10px">
<button class="btn btn-primary"  type="button">
  Editar
</button>
</div>
</form>
</div>
<div class="col-md-4 col-xs-4"></div>
<?php// } ?>
</div>
       
              

     

    <div class = "col-md-4 navbar-fixed-bottom">
      <footer>
        <p>&copy; Gabriel Nunes de Siqueira - SMARTINV, 2017.</p>
      </footer>
    </div> <!-- /container -->

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
