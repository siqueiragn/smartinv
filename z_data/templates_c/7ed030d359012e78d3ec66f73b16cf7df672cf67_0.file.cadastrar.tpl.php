<?php
/* Smarty version 3.1.31, created on 2017-06-07 00:51:40
  from "C:\xampp\htdocs\workspace\smartinv\app\view\templates\cadastrar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5937784c7bfae9_24093816',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ed030d359012e78d3ec66f73b16cf7df672cf67' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\app\\view\\templates\\cadastrar.tpl',
      1 => 1496807497,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5937784c7bfae9_24093816 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="col-md-4 col-xs-4" style="margin-top: 15%">
<form id="formLogin" class="login-form" action="/login/valida" method="post" >        
    <div class="form-group">
              <input type="text" placeholder="Usuário" name="usuario" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Senha" name="senha" class="form-control">
            </div>
           
            <div class="wrapper">
            <button type="submit" class="btn btn-success">Entrar</button>
          	</div>
    
    <!-- <div class="login-wrap">
        <p class="login-img"><i class="icon_contacts"></i></p>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_profile"></i></span>
            <input type="text" name="usuario" class="form-control" placeholder="UsuÃ¡rio" autofocus>
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
    </div> -->
</form>
</div>
<div class="col-md-4 col-xs-4"></div><?php }
}
