<?php
/* Smarty version 3.1.31, created on 2017-06-06 15:57:37
  from "C:\xampp\htdocs\workspace\smartinv\core\view\templates\generic\header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5936fb21b8ae80_41129567',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd81bf34865986597dfe367f618a316cd85b1b1c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\core\\view\\templates\\generic\\header.tpl',
      1 => 1495566673,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5936fb21b8ae80_41129567 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title><?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
 </title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-language" content="pt, pt-br" />
        <meta http-equiv="cache-control" content="public" />
        <meta http-equiv="imagetoolbar" content="no" />

        <meta name="DC.title" content="<?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
" />
        <meta name="DC.creator" content="Marcio Bigolin" />
        <meta name="DC.creator.address" content="marcio.bigolinn@gmail.com" />
        <meta name="DC.description" content="<?php echo $_smarty_tpl->tpl_vars['DESCRIPTION']->value;?>
" />
        <meta name="author" content="Marcio Bigolin" />
        <meta name="language" content="pt-br" />
        <meta name="classification" content="Internet" />
        <meta name="robots" content="index, follow" />
        <meta name="rating" content="general" />
        <meta name="copyright" content="Marcio Bigolin, 2015" />
        <meta name="doc-rights" content="Public" />
        <meta name="geo.region" content="RS"/>
        <meta name="geo.placename" content="Canoas" />
        <meta name="distribution" content="Local" />
        <meta name="revisit-after" content="none" />
        <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['KEYWORDS']->value;?>
" />
        <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['DESCRIPTION']->value;?>
" />

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CDN']->value->getCSS(), 'src');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['src']->value) {
?>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['src']->value;?>
"/>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['filesCSS']->value, 'file');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['file']->value) {
?>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
/css/<?php echo $_smarty_tpl->tpl_vars['file']->value;?>
.css"/>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    </head>
    <body>
    <?php }
}
