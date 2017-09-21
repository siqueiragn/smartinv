<?php
/* Smarty version 3.1.31, created on 2017-06-06 16:10:28
  from "C:\xampp\htdocs\workspace\smartinv\core\view\templates\componentes\tabelas\tabela_manter_dados.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5936fe2452ff50_80444062',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93bebd864205774684aad30273011ad720642aff' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\core\\view\\templates\\componentes\\tabelas\\tabela_manter_dados.tpl',
      1 => 1495566673,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5936fe2452ff50_80444062 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="tabela<?php echo $_smarty_tpl->tpl_vars['ID_TABELA']->value;?>
">
    <table id="tabelaDados<?php echo $_smarty_tpl->tpl_vars['ID_TABELA']->value;?>
"></table>
    <div id="tabelaPaginacao<?php echo $_smarty_tpl->tpl_vars['ID_TABELA']->value;?>
"></div>
</div>
<div id="graficoGerado"></div>
<?php }
}
