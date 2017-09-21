<?php
//requisita classe de controle de erros.
require_once(CORE . 'controller/errorTracker/ErrorHandler.class.php');

//Requisita arquivo com funções para tratamento de erros.
require_once(CORE . 'controller/errorTracker/funcoes_erro.php');

//Autoloader de exceções
require_once(CORE . 'controller/errorTracker/requires.php');

//Registra erros fatais
register_shutdown_function('checkFatal');

//Registra função para tratamento de erros comuns
set_error_handler( 'logErro' );

//Registra Função para tratamento de exceções não capturadas
set_exception_handler( 'logExcecao' );

//Configura o PHP para o correto tratamento de erros.
ini_set( 'display_errors', 'off' );
error_reporting( E_ALL );
