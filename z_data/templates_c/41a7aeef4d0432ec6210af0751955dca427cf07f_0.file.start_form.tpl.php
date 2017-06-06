<?php
/* Smarty version 3.1.31, created on 2017-06-06 16:11:40
  from "C:\xampp\htdocs\workspace\smartinv\core\view\templates\generic\start_form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5936fe6ca855c4_14260491',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41a7aeef4d0432ec6210af0751955dca427cf07f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\core\\view\\templates\\generic\\start_form.tpl',
      1 => 1495566667,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5936fe6ca855c4_14260491 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form class="form-horizontal" role="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" enctype="multipart/form-data" <?php if (isset($_smarty_tpl->tpl_vars['target']->value)) {
echo $_smarty_tpl->tpl_vars['target']->value;
}?> id="formPrincipal">
	<fieldset id="agrupador">
		<a href="#inicioFormulario" id="inicioFormulario" class="hidden">Inicio do formulário</a>
<?php }
}
