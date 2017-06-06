<?php
/* Smarty version 3.1.31, created on 2017-06-06 16:11:41
  from "C:\xampp\htdocs\workspace\smartinv\core\view\templates\generic\end_form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5936fe6d3b6c69_12344041',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbbcdee83ffc7fc22c01e171480c02cae16951bd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\core\\view\\templates\\generic\\end_form.tpl',
      1 => 1495566670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5936fe6d3b6c69_12344041 (Smarty_Internal_Template $_smarty_tpl) {
if (!isset($_smarty_tpl->tpl_vars['WITHOUT_BUTTONS']->value)) {?>
	<fieldset id="formFinal">
                    <div class="form-group">

                    <div class="col-sm-offset-2 col-sm-1">
                        <button type="reset" class="btn btn-default btn-danger">Limpar</button>
                    </div>

                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-default btn-success">Enviar</button>
                    </div>
                </div>
 	</fieldset>
<?php }?>	
    </fieldset>
</form>
<?php }
}
