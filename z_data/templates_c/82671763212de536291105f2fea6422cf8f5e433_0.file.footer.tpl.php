<?php
/* Smarty version 3.1.31, created on 2017-06-06 15:57:38
  from "C:\xampp\htdocs\workspace\smartinv\core\view\templates\generic\footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5936fb224891e7_60429199',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82671763212de536291105f2fea6422cf8f5e433' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\core\\view\\templates\\generic\\footer.tpl',
      1 => 1495566666,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5936fb224891e7_60429199 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <?php echo '<script'; ?>
 type="text/javascript">
        <!--
        var caminhoImagens = "<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
/imagens/";
        var BASE_URL = "<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
";
        
        <?php if ($_smarty_tpl->tpl_vars['selfScript']->value) {?>    
        <?php echo $_smarty_tpl->tpl_vars['selfScript']->value;?>

        <?php }?>
        -->
    <?php echo '</script'; ?>
>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['CDN']->value->getJS(), 'lib');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['lib']->value) {
?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['lib']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['lib']->value->getSha()) {?>integrity="<?php echo $_smarty_tpl->tpl_vars['lib']->value->getSha();?>
" crossorigin="anonymous"<?php }?> ><?php echo '</script'; ?>
>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['libsJS']->value, 'scriptJavaScript');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['scriptJavaScript']->value) {
?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['scriptJavaScript']->value;?>
.js"><?php echo '</script'; ?>
>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['scripts']->value, 'scriptJavaScript');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['scriptJavaScript']->value) {
?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
/js/<?php echo $_smarty_tpl->tpl_vars['scriptJavaScript']->value;?>
.js"><?php echo '</script'; ?>
>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


<?php if ($_smarty_tpl->tpl_vars['selfScript']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript">
        <!--
        <?php echo $_smarty_tpl->tpl_vars['selfScriptPos']->value;?>

        -->
    <?php echo '</script'; ?>
>
<?php }?>
    <!--<noscript>
	<p class="vermelho">
		Seu navegador não possui JavaScript algumas funcionalidades do sistema poderá ser afetada
	</p>
    </noscript>-->
</body>
</html>
<?php }
}
