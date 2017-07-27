<?php
/* Smarty version 3.1.31, created on 2017-07-27 01:08:41
  from "C:\xampp\htdocs\workspace\smartinv\app\view\templates\menu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59796749a82189_58953164',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '446ec38b57221146da45a07673a4bc2815e02664' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\app\\view\\templates\\menu.tpl',
      1 => 1501127678,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59796749a82189_58953164 (Smarty_Internal_Template $_smarty_tpl) {
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
     <!-- <div class="container"> -->
        
        <div class="navbar-header" style="margin-left: 20px">
        <a id="logotitle"  href="/home"> SmartInv </a>
        </div>        
<ul class="nav nav-tabs navbar-right" style="border: none; padding-top: 10px; margin-right: 20px;">
  <li role="presentation"><a id="lnk" href="/home">Home</a></li>
  <li class="dropdown">
                    <a id="lnk" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
 Componentes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a style="color: black" href="memoria"> Memórias </a></li>
<li><a style="color: black" href="../discorigido"> Discos Rígidos </a></li>
<li><a style="color: black" href="../processador"> Processadores </a></li>
<li><a style="color: black" href="../driver"> Drivers </a></li>
<li><a style="color: black" href="../fonte"> Fontes de Alimentação </a></li>
<li><a style="color: black" href="../placamae"> Placas Mães </a></li>
<li><a style="color: black" href="../computador"> Computadores </a></li>
<hr>
<li><a style="color: black" href="../barramento"> Barramentos </a></li>
                    </ul>
                </li>
  <!-- <li role="presentation"><a id="lnk" href="#">Alguma coisa</a></li>
  <li role="presentation"><a id="lnk" href="#">Outra coisa</a></li>
  <li role="presentation"><a id="lnk" href="#">Ajuda</a></li>
  <li role="presentation"><a id="lnk" href="#">Mais coisa</a></li> -->
  <li class="dropdown">
<a id="lnk" href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
Perfil
</a>
<ul class="dropdown-menu">
<li><a href="/usuario">Gerenciar</a></li>
<li><a href="/login/logout">Logout</a></li>
</ul>
</li>


</ul>

    <!--  </div> -->
      
    </nav>
    
    <div style="padding-top: 20px">
      <div class="col-md-12 col-xs-12 col-lg-12"><?php }
}
