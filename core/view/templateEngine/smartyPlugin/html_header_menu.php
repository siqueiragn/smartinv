<?php

/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {html_header_menu} function plugin
 * File:       html_header_menu.php<br>
 * Type:       function<br>
 * Name:       html_form_component<br>
 * Date:       22.Feb.2016<br>
 * Purpose:    Create a menu bootstrap component <br>
 * Params:
 * <pre>
 * - menu       (required) - associative array
 * - search     (optional) - boolean
 * </pre>
 * Examples:
 * <pre>
 * {html_header_menu content=$menu}
 * </pre>
 *
 * @author  Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 *
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 *
 * @return string
 */
function smarty_function_html_header_menu($params, $template)
{
    $search = true;
    extract($params);
    $html = '<header id="cabecalho">
             <nav class=" navbar navbar-default
                navbar-collapse 
                ">
      <div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</button>
<h1><a class="navbar-brand" href="' . $menu->getLogo()->getAction() . '">' . $menu->getLogo()->getLabel() . '</a></h1>
</div>
<div class="navbar-collapse collapse navbar-responsive-collapse">';
    $html .= '<ul class="nav navbar-nav">' . PHP_EOL;
    foreach ($menu->getMenuPrincipal() as $key => $item) {

        if (is_object($item) || is_array($item)) {
            $html .= '<li class="dropdown">  
        <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">' . $key . ' <b class="caret"></b></a>
        <ul class="dropdown-menu">';
            foreach ($item as $label => $acao) {
                $html .= printItem(new MenuItem($label, $acao));
            }
            $html .= '</ul> </li>' . PHP_EOL;
        } else {
            $html .=printItem(new MenuItem($key, $item));
        }
    }
    $html .='</ul>';

    if ($search) {
        $html .='<form class = "navbar-form navbar-left">
<input class = "form-control col-lg-8" placeholder = "Acesso rápido" type = "text">
</form>';
    }
    $html .= '<ul class="nav navbar-nav navbar-right">';
    foreach ($menu->getMenuAuxiliar() as $key => $item) {

        if (is_object($item) || is_array($item)) {
            $html .= '<li class="dropdown">  
        <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">' . $key . ' <b class="caret"></b></a>
        <ul class="dropdown-menu">';
            foreach ($item as $label => $acao) {
                $html .= printItem(new MenuItem($label, $acao));
            }
            $html .= '</ul> </li>';
        } else {
            $html .=printItem(new MenuItem($key, $item));
        }
    }
    $html .='</ul>      </div>  </nav>  </header>';

    return $html;
}

function printItem(MenuItem $item)
{
    return '    <li><a href="' . $item->getAction() . '">' . $item->getLabel() . '</a></li>' . PHP_EOL;
}
