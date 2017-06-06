<?php
$contentType = strpos($_SERVER['HTTP_ACCEPT'], 'application/html') === false ? 'text/html' : 'application/html';
header('Content-Type: ' . $contentType . '; charset=utf-8');
session_start();
require_once('../confs/config.php');
require_once(CORE . 'controller/errorTracker/controle_erros.php');

require_once(CORE. 'Factory.class.php');

$fabricaAcao = new Factory();
$fabricaAcao->start();
?>
