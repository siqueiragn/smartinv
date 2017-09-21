<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {html_form_component} function plugin
 * File:       html_form_component.php<br>
 * Type:       function<br>
 * Name:       html_form_component<br>
 * Date:       22.Feb.2016<br>
 * Purpose:    Create a bootstrap component form<br>
 * Params:
 * <pre>
 * - name       (required) - string 
 * - label      (required) - string 
 * - type       (optional) - string 
 * - value      (optional) - string
 * - options    (optional) - associative array
 * </pre>
 * Examples:
 * <pre>
 * {html_form_component values=$ids output=$names}
 * {html_radios values=$ids name='box' separator='<br>' output=$names}
 * {html_radios values=$ids checked=$checked separator='<br>' output=$names}
 * </pre>
 *
 * @author  Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 *
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 *
 * @return string
 * @uses    smarty_function_escape_special_chars()
 */
function smarty_function_html_form_component($params, $template)
{

    $name = null;
    $label = null;
    $value = '';
    $type = 'text';
    $options = null;
    
    extract($params);

    if($type == 'text'){
        return _geraInput($label, $name, $value);
    }
    
    if($type == 'textarea'){
        return _geraTextarea($label, $name, $value);
    }

    
}

function _geraTextArea($label, $name, $value ){
    return '<div class="form-group">
        <label class="control-label col-sm-2" for="'  . $name . '">'. $label. '</label>
        <div class="col-sm-8">
            <textarea id="' . $name . '" name="' . $name . '" class="form-control">' . $value . '</textarea>
        </div>
    </div>';
}

function _geraInput($label, $name, $value){
        return '<div class="form-group">
        <label class="control-label col-sm-2" for="'  . $name . '">'. $label. '</label>
        <div class="col-sm-8">
            <input type="text" id="' . $name . '" name="' . $name . '" value="' . $value . '" class="form-control" />
        </div>
    </div>';
}

