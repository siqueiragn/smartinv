<?php

require_once CORE . 'controller/AutoLoader.class.php';
require_once CORE . '../vendor/autoload.php';
require_once CORE . 'util/HELPER.php';

use core\controller;

$loader = new controller\AutoLoader();

$loader->register();

$loader->addNamespace('core', CORE );

$loader->addClass('AbstractController', CORE . 'controller/AbstractController');
$loader->addClass('AbstractView', CORE . 'view/AbstractView');

//Model
$loader->addClass('AbstractModel', CORE . 'model/AbstractModel');
$loader->addClass('Model', CORE . 'model/Model');
$loader->addClass('AbstractDAO', CORE . 'model/AbstractDAO');

//Util
$loader->addClass('StringUtil', CORE . 'util/StringUtil');
$loader->addClass('DebugUtil', CORE . 'util/DebugUtil');
$loader->addClass('ValidatorUtil', CORE . 'util/ValidatorUtil');
$loader->addClass('DateUtil', CORE . 'util/DateUtil');
$loader->addClass('MailUtil', CORE . 'util/MailUtil');

//add Libs common
$loader->addClass('ArquivoUpload', CORE . 'libs/arquivo/ArquivoUpload');
$loader->addClass('Redimensionador', CORE . 'libs/imagem/Redimensionador');
$loader->addClass('Browser', CORE . 'libs/browser/Browser');
$loader->addClass('PDF', CORE . 'libs/pdf/PDF');
$loader->addClass('Aes', CORE . 'libs/crypto/Aes');


//View
$loader->addClass('Menu', CORE .'view/menu/Menu');
$loader->addClass('MenuItem', CORE .'view/menu/MenuItem');

//interfaces
$loader->addClass('DTOInterface', CORE . 'model/DTOInterface');
$loader->addClass('ObjetoInsercao', CORE . 'model/io/ObjetoInsercao');
$loader->addClass('FileTupleTrait', CORE . 'model/io/FileTupleTrait');


//Componente
$loader->addClass('Componente', CORE . 'componentes/Componente');

$GLOBALS['loader'] = $loader;

//Chama o AutoLoader de componente
require_once CORE . 'componentes/component_register.php';
