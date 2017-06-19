<form>
<select name="mysql">
<?php
session_destroy();
session_start();
require('db/DB.class.php');
require('db/DB2.class.php');
$db = new DB();
$db2 = new DB2();

$consultaMYSQL = $db2->query("SELECT table_name FROM INFORMATION_SCHEMA.TABLES");
$consultaPGSQL = $db->query("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'public'");

// TABELAS MYSQL

foreach($consultaMYSQL as $line) { 
if(substr($line['table_name'],0,4)=='glpi')
echo "<option value='".$line['table_name']."'>".$line['table_name']."</option>"; 
}

// TABELAS PGSQL

echo "</select><select name='pgsql'>";	
foreach($consultaPGSQL as $line) {
echo "<option value='".$line['table_name']."'>".$line['table_name']."</option>";
	}

echo "</select><input type='submit'></form>";

// COLUNAS MYSQL
echo "<form>";
if(isset($_REQUEST['mysql']))
$_SESSION['tb_mysql'] = $_REQUEST['mysql'];
$consultaMYSQL = $db2->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".
$_SESSION['tb_mysql']."'");

echo "<select name='columnmysql'>";
foreach($consultaMYSQL as $line){	
	echo "<option value='".$line['COLUMN_NAME']."'>".$line['COLUMN_NAME']."</option>";
	//$colMYSQL .= $line['COLUMN_NAME'] .", ";

	}
echo "</select>";

// COLUNAS PGSQL
if(isset($_REQUEST['pgsql']))
$_SESSION['tb_pgsql'] = $_REQUEST['pgsql'];
$consultaPGSQL = $db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$_SESSION['tb_pgsql']."'");
echo "<select name='columnpgsql'>";
foreach($consultaPGSQL as $line){
echo "<option value='".$line['column_name']."'>".$line['column_name']."</option>";
$colPGSQL .= $line['column_name'] .", ";
}


echo "</select><input type='submit'></form>";

// COLUNAS SELECIONADAS

if(isset($_REQUEST['columnmysql'])){
$_SESSION['col_mysql'] .= $_REQUEST['columnmysql'] . ', ';
//echo $_SESSION['col_mysql'];
} else {
	$_SESSION['col_mysql'] = '';
}
echo "<br>";
if(isset($_REQUEST['columnpgsql'])){
$_SESSION['col_pgsql'] .= $_REQUEST['columnpgsql'] . ', ';
//echo $_SESSION['col_pgsql'];
} else {
	$_SESSION['col_pgsql'] = '';
}

// CONSULTAR MYSQL

// INSERIR
echo "<br>";
echo "INSERT INTO ".$_SESSION['tb_pgsql']."(".substr_replace($_SESSION['col_pgsql'],'',strlen($_SESSION['col_pgsql'])-2).") VALUES(".substr_replace($_SESSION['col_mysql'],'',strlen($_SESSION['col_mysql'])-2).")";

echo "<hr></hr>";
$consultaMYSQL = $db2->query("SELECT ".substr_replace($_SESSION['col_mysql'],'',strlen($_SESSION['col_mysql'])-2)." FROM ".$_SESSION['tb_mysql']);
echo "<pre>";
foreach($consultaMYSQL as $line){
$query = "INSERT INTO ".$_SESSION['tb_pgsql']."(".substr_replace($_SESSION['col_pgsql'],'',strlen($_SESSION['col_pgsql'])-2).") VALUES(";
for ($i=0;$i<sizeof($line)/2;$i++){
		$query .= $line[$i] . ", ";
}
echo substr_replace($query,');',strlen($query)-2) . "<br>";
}


?>

