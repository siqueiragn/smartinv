<?php
/* Smarty version 3.1.31, created on 2017-07-25 20:22:31
  from "C:\xampp\htdocs\workspace\smartinv\app\view\templates\forms\processador.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5977d2b71a63a7_86309661',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fd8c4f8059f0c9c9b1c2eb259e2d8804fde09ff7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\app\\view\\templates\\forms\\processador.tpl',
      1 => 1501024799,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5977d2b71a63a7_86309661 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\xampp\\htdocs\\workspace\\smartinv\\vendor\\smarty\\smarty\\libs\\plugins\\function.html_options.php';
?>

<fieldset class="formPadrao">
     <legend>Processador</legend>
             <input type="hidden" id="idProcessador" name="idProcessador" value="<?php echo $_smarty_tpl->tpl_vars['processador']->value->getIdProcessador();?>
" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="<?php echo $_smarty_tpl->tpl_vars['processador']->value->getNome();?>
" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="frequencia">Frequencia</label>
              <div class="col-sm-8">
                 <input type="text" id="frequencia" name="frequencia" value="<?php echo $_smarty_tpl->tpl_vars['processador']->value->getFrequencia();?>
" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="socket">Socket</label>
              <div class="col-sm-8">
                 <input type="text" id="socket" name="socket" value="<?php echo $_smarty_tpl->tpl_vars['processador']->value->getSocket();?>
" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" ><?php echo $_smarty_tpl->tpl_vars['processador']->value->getDescricao();?>
</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['listaComputador']->value,'selected'=>$_smarty_tpl->tpl_vars['processador']->value->getComputador()),$_smarty_tpl);?>

             </select>

              </div>
         </div>
</fieldset>

<?php }
}
