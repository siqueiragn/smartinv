<?php
use core\libs\login\LoginBanco;
/**
 * Classe principal do sistema responsável por criar a interface padrão assim como verificar 
 * a sessão e permissões do usuário.
 * 
 * @author Gabriel Nunes de Siqueira - <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0
 */
class ControladorGeral extends AbstractController
{

    private $conteudoMenu;
    protected $modelo;

    /**
     *
     * @var LoginBanco 
     */
    protected $login;

    public function __construct()
    {
        $this->modelo = new Modelo();
        $this->view = new VisualizadorGeral();
        $this->login = new LoginBanco(LOGIN_CHAVE, $this->modelo);
		
        
         if (!$this->verificaLogado()) {
             $this->login->saveRedirect();
             $this->redirect('/login');
             exit();
         }
         $this->view->attValue('usuario', $this->login->getUsuario());
    }

    public function paginaNaoEncontrada()
    {
        $this->view->setTitle('Não encontrada');
    }

    public function index()
    {
    	//$this->view = null;
    	$this->view = new VisualizadorRegistro();
    	/*
        $this->view->setTitle('SMARTINV - 2017');
        $this->view->addTemplate("menuLogin");
        
*/
    }

    public function home()
    {
        $this->view = new VisualizadorGeral();
        $this->view->setTitle('Home');
        $this->view->addTemplate('imagens');
        /* $controlador = new ControladorGeral();
        $this->view = $controlador->getView(); */
    }
    public function iniciarAlgoritmo()
    {
        $this->view->addTemplate('configurar');
        
        if(isset($_POST['iniciar'])){
        $this->modelo->DB()->delete('algoritmo', '1=1');
        
        $this->view = new VisualizadorGeral();
        $this->view->setTitle('Algoritmo');
        $this->view->addTemplate('forms/algoritmo');
        
        $placaMae = new PlacaMaeDAO();
        $dadosPlacaMae = $placaMae->getLista(null, "id_placa_mae ASC");
        
$processador = new ProcessadorDAO();
$dadosProcessador = $processador->getLista(null, "id_processador ASC");
$arrayIDProcessadorExcept = [];

$memoria = new MemoriaDAO();
$dadosMemoria = $memoria->getLista(null, "id_memoria ASC"); 
$arrayIDMemoriaExcept = [];

$discoRigido = new DiscoRigidoDAO();
$dadosDRigido = $discoRigido->getLista(null, "id_disco_rigido ASC");
$arrayIDDiscoExcept = [];

$fonte = new FonteDAO();
$dadosFonte = $fonte->getLista(null, "id_fonte ASC");
$arrayIDFonteExcept = [];

$contador = 0;
$arrayComputador = [];
       
        foreach ($dadosPlacaMae as $itemPlacaMae){
                $arrayComputador[]['id_placa_mae'] = $itemPlacaMae->getIdPlacaMae();
                $processadorAtual = "null";
                $memoriaAtual = "null";
                $discoAtual = "null";
		$fonteAtual = "null";
                
                $selectProcessor = new Processador();
                foreach($dadosProcessador as $itemProcessador){
                    if($itemProcessador->getSocket() == $itemPlacaMae->getSocket() && !in_array($itemProcessador->getIdProcessador(), $arrayIDProcessadorExcept)){
                      
                        if($itemProcessador->getFrequencia() >= $selectProcessor->getFrequencia() && is_null($itemProcessador->getComputador())){
                            $key = array_search($selectProcessor->getIdProcessador(), $arrayIDProcessadorExcept);
                            if($key!==false){
                                unset($arrayIDProcessadorExcept[$key]);
                            }
                            
                            $selectProcessor = $itemProcessador;
                            $arrayIDProcessadorExcept[] = $itemProcessador->getIdProcessador();
                            $processadorAtual = $itemProcessador->getIdProcessador();
                        }
                    }

                }
                
                 $selectMemoria = new Memoria();
                foreach($dadosMemoria as $itemMemoria){
                    
                 //  echo $itemMemoria->getTipo() . " MEMORIA 1 MOBO " . $itemPlacaMae->getSlotMemoria() ."<br>";
                    
                    if($itemMemoria->getTipo() == $itemPlacaMae->getSlotMemoria() && !in_array($itemMemoria->getIdMemoria(), $arrayIDMemoriaExcept) && is_null($itemMemoria->getComputador())){
                      
                        if($itemMemoria->getFrequencia() >= $selectMemoria->getFrequencia()){
                          if($itemMemoria->getCapacidade() >= $selectMemoria->getCapacidade()){
                            $key = array_search($selectMemoria->getIdMemoria(), $arrayIDMemoriaExcept);
                            if($key!==false){
                                unset($arrayIDMemoriaExcept[$key]);
                           }
                            
                            $selectMemoria = $itemMemoria;
                            $arrayIDMemoriaExcept[] = $itemMemoria->getIdMemoria();
                            $memoriaAtual = $itemMemoria->getIdMemoria();
                         }
            
                            }
                        else {
                              // echo $itemMemoria->getCapacidade() . " " . $selectMemoria->getCapacidade();
                            
                              if ($itemMemoria->getCapacidade() >= $selectMemoria->getCapacidade()){
                                  $key = array_search($selectMemoria->getIdMemoria(), $arrayIDMemoriaExcept);
                                  if($key!==false){
                                      unset($arrayIDMemoriaExcept[$key]);
                                  }
                                  
                                  $memoriaAtual = $itemMemoria->getIdMemoria();
                                 $arrayIDMemoriaExcept[] = $itemMemoria->getIdMemoria();
                                 $selectMemoria = $itemMemoria;
                                 
                              }
                          }
                  
                }
             
                }
                
                // ================== CARREGA AS INTERFACES DA PLACA MÃE
                $interfaces = new BarramentoPlacamaeDAO();
                    $dadosInterface = $interfaces->getLista();
                    $arrayInterfaces = [];
                   
                   foreach($dadosInterface as $item){
                       if($item->getIdPlacaMae() == $itemPlacaMae->getIdPlacaMae()){
                           $arrayInterfaces[] = $item->getIdBarramento();
                       }
                   }
                
                 /*    echo "<pre>";
                   print_r($arrayInterfaces);
                   echo "</pre>"; 
                 */
                // ========================================================
                
                $selectHD = new DiscoRigido();
                 foreach($dadosDRigido as $itemDiscoRigido){
                     
                      /* echo $itemDiscoRigido->getBarramento()."<br>";
                     echo array_search($itemDiscoRigido->getBarramento(), $arrayInterfaces)." ACHOU <br>";  */
                     if(!in_array($itemDiscoRigido->getIdDiscoRigido(), $arrayIDDiscoExcept) && is_null($itemDiscoRigido->getComputador())){
                         
                        /*  if($itemDiscoRigido->getVCache() >= $selectHD->getVCache()){
                             if($itemDiscoRigido->getRpm() >= $selectHD->getRpm()) { */
                         if(array_search($itemDiscoRigido->getBarramento(), $arrayInterfaces) !== false){
                         if($itemDiscoRigido->getCapacidade() >= $selectHD->getCapacidade()){
                                 
                                         $key = array_search($selectHD->getIdDiscoRigido(), $arrayIDDiscoExcept);
                                         if($key !==false){
                                             unset($arrayIDDiscoExcept[$key]);
                                         }
                                       
                                         $discoAtual = $itemDiscoRigido->getIdDiscoRigido();
                                         $arrayIDDiscoExcept[] = $itemDiscoRigido->getIdDiscoRigido();
                                         $selectHD = $itemDiscoRigido;
                                     }
                                 }
                            /*  }
                       
                             } */
                               //  echo "Achou! ".$itemDiscoRigido->getBarramento()." ".$itemDiscoRigido->getNome()."<br>";
                         }
                         /* print_r($arrayInterfaces); */
                     } 
                 if($processadorAtual != 'null' && $memoriaAtual != 'null' && $discoAtual != 'null'){
		$selectFonte = new Fonte();
		foreach($dadosFonte as $itemFonte){
		if(!in_array($itemFonte->getIdFonte(), $arrayIDFonteExcept) && is_null($itemFonte->getComputador())){
			if($itemFonte->getPotencia()>$selectFonte->getPotencia()) {
			$key = array_search($selectFonte->getIdFonte(), $arrayIDFonteExcept);
			if($key !== false){
				unset($arrayIDFonteExcept[$key]);			
			}
			$fonteAtual = $itemFonte->getIdFonte();
			$arrayIDFonteExcept[] = $itemFonte->getIdFonte();
			$selectFonte = $itemFonte;
			}
		}
		}
}
                $arrayComputador[$contador]['id_placa_mae'] = $itemPlacaMae->getIdPlacaMae();
		$arrayComputador[$contador]['id_processador'] = $processadorAtual;
                $arrayComputador[$contador]['id_memoria'] = $memoriaAtual;
                $arrayComputador[$contador]['id_disco_rigido'] = $discoAtual;
		$arrayComputador[$contador]['id_fonte'] = $fonteAtual;
            $contador++;
        
        }
        
      
      
        
       // print_r($arrayComputador);
       
                $this->view->attValue('lista',$arrayComputador);
                 $alg = new AlgoritmoDAO();
                 $alg->inserirMultiplos($arrayComputador);
                 $this->view->attValue('url',$alg->getMenorID());
                
                    
        }
        
     
    }

    public function contato()
    {
        $this->view->setTitle('Contato');
        $this->view->startForm('contatoFim');
        $this->view->addTemplate('paginas/contato');
        $this->view->endForm();
    }
    
    public function relatorioComponentes(){
        $placaMaeDAO = new PlacaMaeDAO();
        $placaMae = $placaMaeDAO->getAll();
        $contPlacaMae = count($placaMae);
        
        $processadorDAO = new ProcessadorDAO();
        $processador = $processadorDAO->getAll();
        $contProcessador = count($processador);
        
        $memoriaDAO = new MemoriaDAO();
        $memoria = $memoriaDAO->getAll();
        $contMemoria = count($memoria);
        
        $discoRigidoDAO = new DiscoRigidoDAO();
        $discoRigido = $discoRigidoDAO->getAll();
        $contDiscoRigido = count($discoRigido);
        
        $placaVideoDAO = new PlacaVideoDAO();
        $placaVideo = $placaVideoDAO->getAll();
        $contPlacaVideo = count($placaVideo);
        
        $driverDAO = new DriverDAO();
        $driver = $driverDAO->getAll();
        $contDriver = count($driver);
        
        $fonteDAO = new FonteDAO();
        $fonte = $fonteDAO->getAll();
        $contFonte = count($fonte);
        
        $this->view->attValue('cPlacaMae',$contPlacaMae);
        $this->view->attValue('cProcessador',$contProcessador);
        $this->view->attValue('cMemoria',$contMemoria);
        $this->view->attValue('cDiscoRigido',$contDiscoRigido);
        $this->view->attValue('cPlacaVideo',$contPlacaVideo);
        $this->view->attValue('cDriver',$contDriver);
        $this->view->attValue('cFonte',$contFonte);
        
        $this->view->attValue('placaMae',$placaMae);
        $this->view->attValue('processador',$processador);
        $this->view->attValue('memoria',$memoria);
        $this->view->attValue('discoRigido',$discoRigido);
        $this->view->attValue('placaVideo',$placaVideo);
        $this->view->attValue('driver',$driver);
        $this->view->attValue('fonte',$fonte);
        
        $this->view->addCSS('custom');
        $this->view->addTemplate('relatorioComponentes');
        
       
    }
    
    public function relatorioComputador()
    {
        $computadorDAO = new ComputadorDAO();
       
        $dadosComputador = $computadorDAO->getLista();
       
     foreach ($dadosComputador as $computador){
         
         $placaMaeDAO = new PlacaMaeDAO();
         $placaMae = $placaMaeDAO->getByComputerID($computador->getID());
        // if($placaMae->getNome() != '')
             $arrayComputador[$computador->getNome()]['placa_mae'] = $placaMae->getID() . ' - ' .$placaMae->getNome();

         $processadorDAO = new ProcessadorDAO();
         $processador = $processadorDAO->getByComputerID($computador->getID());
      //   if($processador->getNome() != '')
             $arrayComputador[$computador->getNome()]['processador'] = $processador->getID().' - '.$processador->getNome();
                        
         $memoriaDAO = new MemoriaDAO();
         $memoria = $memoriaDAO->getByComputerID($computador->getID());
       //  if($memoria->getNome() != '')
             $arrayComputador[$computador->getNome()]['memoria'] = $memoria->getID() . ' - ' . $memoria->getNome();
        
         $discoRigidoDAO = new DiscoRigidoDAO();
         $discoRigido = $discoRigidoDAO->getByComputerID($computador->getID());
      //   if($discoRigido->getNome() != '')
             $arrayComputador[$computador->getNome()]['disco_rigido'] = $discoRigido->getID() . ' - ' .$discoRigido->getNome();
                                          
         $fonteDAO = new FonteDAO();
         $fonte = $fonteDAO->getByComputerID($computador->getID());
      //   if($fonte->getNome() != '')
             $arrayComputador[$computador->getNome()]['fonte'] = $fonte->getID() . ' - ' . $fonte->getNome();                      
                                  
         $placaVideoDAO = new PlacaVideoDAO();
         $placaVideo = $placaVideoDAO->getByComputerID($computador->getID());
      //   if($placaVideo->getNome()!='')
             $arrayComputador[$computador->getNome()]['placa_video'] = $placaVideo->getID() . ' - ' .$placaVideo->getNome();
         
         $driverDAO = new DriverDAO();
         $driver = $driverDAO->getByComputerID($computador->getID());
      //   if($driver->getNome()!='')
            $arrayComputador[$computador->getNome()]['driver'] = $driver->getID() . ' - ' .$driver->getNome();
                           
     }
     
    
     $this->view->attValue('lista', isset($arrayComputador)?$arrayComputador:null);
     $this->view->addTemplate('relatorioComputador');
     
    }
    
    public function __destruct()
    {
    	if(get_class($this->view)=='VisualizadorRegistro' ||   $this->view->getTitle() == 'Home')
    		$this->view->addTemplate('rodapeLogin');
    	else
    	$this->view->addTemplate('rodape');
    	parent::__destruct();
    }
    
    
      private function verificaLogado()
    {
        return $this->login->verificaLogado();
    }

}
