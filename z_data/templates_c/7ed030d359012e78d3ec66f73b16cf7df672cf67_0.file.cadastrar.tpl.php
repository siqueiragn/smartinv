<?php
/* Smarty version 3.1.31, created on 2017-06-06 16:01:17
  from "C:\xampp\htdocs\workspace\smartinv\app\view\templates\cadastrar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5936fbfdc4e7f4_54004561',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ed030d359012e78d3ec66f73b16cf7df672cf67' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\app\\view\\templates\\cadastrar.tpl',
      1 => 1496775666,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5936fbfdc4e7f4_54004561 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form id="formLogin" class="login-form" action="/login/valida" method="post" >        
    <div class="login-wrap">
        <p class="login-img"><i class="icon_contacts"></i></p>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_profile"></i></span>
            <input type="text" name="usuario" class="form-control" placeholder="Usuário" autofocus>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_key_alt"></i></span>
            <input name="senha" type="password" class="form-control" placeholder="Senha">
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_key_alt"></i></span>
            <input name="reSenha" type="password" class="form-control" placeholder="re-Senha">
        </div>
        <button class="btn btn-info btn-lg btn-block" type="submit" id="cadastroBt">Cadastro</button>
    </div>
</form><?php }
}
