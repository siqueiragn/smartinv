
<?php
/**
 * Arquivo com as configurações do sistema nesse arquivo fica as constantes
 * responsáveis pelo funcionamento correto do sistema. Configurações de usuário
 * e senha de Banco de dados por padrão não ficam nesse arquivo.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */

$base =  __DIR__. '/../';


//Constante que define o caminho onde fica o diretorio dos módulos do sistema
define('ROOT', $base. 'app/');

//Constante que define o caminho onde fica o framework servidor do Enyalius
define('CORE', $base . 'core/');

//Constante que define onde ficará os templates do sistema
define('TEMPLATES', ROOT . 'view/templates/');

//Constante para o Framework Smarty utilizar como cache, e outros frameworks usarem
//para armazenar arquivos de cache.
define('CACHE', $base . 'z_data/');

//Constante para o diretorio de logs
define('LOGS', CACHE . 'logs');

//Constante para a definição se o sistema esta em produção ou teste
define('DEBUG', true);

//define a chave de critpografia
define('LOGIN_CHAVE', '56973d6a8dbf7cd58330565thfde2d');

//Configurações de hora
date_default_timezone_set('America/Sao_Paulo');

//Configuração de formato
setlocale(LC_ALL, 'pt_BR');

//Demais configurações
require __DIR__ . '/conf_bd.php';
require __DIR__ . '/conf_mail.php';

