<fieldset class="formPadrao">



{foreach name=outer item=placaMae key=key from=$listaPM}
<h1> {$key} </h1>    
<select id="processador" name="processador" class="form-control">

{foreach key=key item=item from=$placaMae}
{html_options options=$item selected=$selectP}  

  {/foreach}
</select>
{/foreach}
     <div>



</fieldset>
