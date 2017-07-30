<?php
/* Smarty version 3.1.31, created on 2017-07-29 09:46:23
  from "C:\xampp\htdocs\workspace\smartinv\app\view\templates\forms\memoria.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_597c839f704022_38325019',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd4680f48dac1152befb36d18dad7694e988596e0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\workspace\\smartinv\\app\\view\\templates\\forms\\memoria.tpl',
      1 => 1501222925,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_597c839f704022_38325019 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'C:\\xampp\\htdocs\\workspace\\smartinv\\vendor\\smarty\\smarty\\libs\\plugins\\function.html_options.php';
?>

<fieldset class="formPadrao">
     <legend>Memoria</legend>
             <input type="hidden" id="idMemoria" name="idMemoria" value="<?php echo $_smarty_tpl->tpl_vars['memoria']->value->getIdMemoria();?>
" class=" form-control" required  />
         <div class="form-group">
              <label class="control-label col-sm-2" for="nome">Nome</label>
              <div class="col-sm-8">
                 <input type="text" id="nome" name="nome" value="<?php echo $_smarty_tpl->tpl_vars['memoria']->value->getNome();?>
" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="frequencia">Frequencia</label>
              <div class="col-sm-8">
                 <input type="text" id="frequencia" name="frequencia" value="<?php echo $_smarty_tpl->tpl_vars['memoria']->value->getFrequencia();?>
" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="capacidade">Capacidade</label>
              <div class="col-sm-8">
                 <input type="text" id="capacidade" name="capacidade" value="<?php echo $_smarty_tpl->tpl_vars['memoria']->value->getCapacidade();?>
" class="validaInteiro form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo</label>
              <div class="col-sm-8">
                 <input type="text" id="tipo" name="tipo" value="<?php echo $_smarty_tpl->tpl_vars['memoria']->value->getTipo();?>
" class=" form-control"  />
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="descricao">Descrição</label>
              <div class="col-sm-8">
                 <textarea id="descricao" name="descricao" class=" form-control" ><?php echo $_smarty_tpl->tpl_vars['memoria']->value->getDescricao();?>
</textarea>
              </div>
         </div>
         <div class="form-group">
              <label class="control-label col-sm-2" for="computador">Computador</label>
              <div class="col-sm-8">
                 <select id="computador" name="computador" class="form-control">
    		<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['listaComputador']->value,'selected'=>$_smarty_tpl->tpl_vars['memoria']->value->getComputador()),$_smarty_tpl);?>

             </select>

              </div>
         </div>
</fieldset>

<?php }
}
