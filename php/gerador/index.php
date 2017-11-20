<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('gabriel_nunes', '98187625', 'bd_N2', 'webacademico.canoas.ifrs.edu.br'//servidor
          );

$empresas =['Acer','Wallmart','Dell','Piracanjuba','Apple','Samsung','Pirakids','Itautec','Nacional','BIG','Carrefour','Pepsico','Coca-Cola','Bourbon','Dolly'];
$pais = ['Alemanha', 'Austrália', 'Holanda', 'Albânia','Azerbaijão','Brasil','Japão','Marrocos','China','Bósnia'];
$estados = ['Rio Grande do Sul', 'Ohio', 'Osaka','Mato Grosso','Acre','Pernambuco','Amapá','São Paulo','Bahia','Paraíba'];
$cidades = ['Porto Alegre','Feliz','Sertão','Viamão','Cachoeirinha','Sapucaia do Sul','Canoas','Cachoeira do Sul','Gravataí','Alvorada','Esteio'];
$acao = 'insercao';

function criarCEP($tam =9){
  $senha = "";
  $senhas = ['1','2','3','4','5','6','7','8','9','0'];
  for($i =0 ; $i< $tam; $i++){
    $senha =$senha . $senhas[rand(0, sizeof($senhas)-1)];
  }
  return $senha;
}				

$ruas = ['Oswaldo Aranha','Paulo Couto','Av. Papa João XXIII','Drª Maria Zélia Carneiro','Brambila','Borges de Medeiros','Assis Brasil','Açucena'];


																				
if(isset($_POST['gerar'])){

for($a = 0; $a<5; $a++){
	$dados[0] = $a;
	$dados[1] = $pais[rand(0, sizeof($pais)-1)];
  $db->execute("INSERT INTO pais(id_pais,nome) VALUES (?,?)",$dados);
	$dados[0] = $a;
	$dados[1] = $estados[rand(0, sizeof($estados)-1)];
	$dados[2] = rand(0,4);
  $db->execute("INSERT INTO estado(id_estado,nome,pais) VALUES (?,?,?)",$dados);
	$dados[0] = $a;
	$dados[1] = $cidades[rand(0, sizeof($cidades)-1)];
	$dados[2] = rand(0,4);
  $db->execute("INSERT INTO cidade(id_cidade,nome,estado) VALUES (?,?,?)",$dados);
  }

for($i = 0; $i<5; $i++){
	$dados[0] = $i;
}
  
}
?>

<!DOCTYPE html>
<html>>
<head>
<meta charset="UTF-8">
<title> Página 1 </title>
</head>
<body>
<form action="index.php?acao=<?= $acao?>" method="post">
<input type="checkbox" name="gerar"> 
<input type="submit">
</form>
</body>
</html>



