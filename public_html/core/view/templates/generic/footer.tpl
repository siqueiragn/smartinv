    <script type="text/javascript">
        <!--
        var caminhoImagens = "{$BASE_URL}/imagens/";
        var BASE_URL = "{$BASE_URL}";
        
        {if $selfScript}    
        {$selfScript}
        {/if}
        -->
    </script>

{foreach $CDN->getJS() as $lib}
    <script type="text/javascript" src="{$lib}" {if $lib->getSha()}integrity="{$lib->getSha()}" crossorigin="anonymous"{/if} ></script>
{/foreach}

{foreach $libsJS as $scriptJavaScript}
    <script type="text/javascript" src="{$BASE_URL}/{$scriptJavaScript}.js"></script>
{/foreach}

{foreach $scripts as $scriptJavaScript}
    <script type="text/javascript" src="{$BASE_URL}/js/{$scriptJavaScript}.js"></script>
{/foreach}

{if $selfScript}
    <script type="text/javascript">
        <!--
        {$selfScriptPos}
        -->
    </script>
{/if}
    <!--<noscript>
	<p class="vermelho">
		Seu navegador não possui JavaScript algumas funcionalidades do sistema poderá ser afetada
	</p>
    </noscript>-->
</body>
</html>
