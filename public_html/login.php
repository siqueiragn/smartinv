<?php
require '../php/db/DB.class.php';
//$db = new DB();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartInv</title>
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
   
<div class="container">
        <div class="col-md-4"></div>
 		<div class="col-md-4" style="margin-top: 15%">
 		<form class="form" method="POST" action="index.php">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Senha" class="form-control">
            </div>
           
            <div class="wrapper">
            <button type="submit" class="btn btn-success">Entrar</button>
          	</div>
          </form>
 		</div>
		<div class="col-md-4"></div> 
</div>
      
<div class = "col-md-4 navbar-fixed-bottom">
      <footer>
        <p>&copy; Gabriel Nunes de Siqueira - SMARTINV, 2017.</p>
      </footer>
    </div> <!-- /container -->

  </body>
</html>
