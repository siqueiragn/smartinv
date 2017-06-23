<?php
error_reporting(E_ALL);
$con = mysqli_connect('localhost', 'root', '', 'phpaula');
//print_r($con);
$query = "INSERT INTO pessoa(codpessoa,nome,endereco,telefone) VALUES('".$_REQUEST['nome']."','".$_REQUEST['endereco']."','".$_REQUEST['telefone']."')";
//echo $query;
print_r(mysqli_query($con, $query));
 
header("Location: teste.php");
?>