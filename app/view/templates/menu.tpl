<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="navbar-header" style="margin-left: 20px">
   <a id="logotitle"  href="/home"> SmartInv </a>
</div>        
<ul class="nav nav-tabs navbar-right" style="border: none; padding-top: 10px; margin-right: 20px;">
  <li role="presentation"><a id="lnk" href="/home">Home</a></li>
  <li class="dropdown">
    	<a id="lnk" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Componentes </a>
		<ul class="dropdown-menu">
			  <li><a style="color: black" href="/memoria"> Memórias </a></li>
			  <li><a style="color: black" href="/discoRigido"> Discos Rígidos </a></li>
			  <li><a style="color: black" href="/processador"> Processadores </a></li>
			  <li><a style="color: black" href="/driver"> Drivers </a></li>
			  <li><a style="color: black" href="/fonte"> Fontes de Alimentação </a></li>
			  <li><a style="color: black" href="/placaMae"> Placas Mães </a></li>
			  <li><a style="color: black" href="/placaVideo"> Placas de Video </a></li>
			  <li><a style="color: black" href="/computador"> Computadores </a></li>
			  <hr>
			  <li><a style="color: black" href="/barramento"> Interfaces </a></li>
  		</ul>
  </li>
   
  <li class="dropdown"><a id="lnk" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Algoritmo </a>
		<ul class="dropdown-menu">
			  <li><a style="color: black" href="/iniciarAlgoritmo"> Configurar </a></li>
			  <li><a style="color: black" href="/algoritmo"> Resultados </a></li>
  	    </ul>
  </li>

  <li class="dropdown">
		<a id="lnk" href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			Relatório
		</a>
		<ul class="dropdown-menu">
			<li><a href="/relatorioComputador">Computadores</a></li>
			<li><a href="/relatorioComponentes">Componentes</a></li>
		</ul>
  </li>

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


      
    </nav>
    
    <div style="padding-top: 20px">
      <div class="col-md-12 col-xs-12 col-lg-12">

      {include file=$MSG_FILE}