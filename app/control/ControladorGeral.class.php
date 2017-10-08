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
    public function algoritmo()
    {
        $this->view = new VisualizadorGeral();
        $this->view->setTitle('Algoritmo');
        $this->view->addTemplate('forms/algoritmo');
        
        $placaMae = new PlacaMaeDAO();
        $dadosPlacaMae = $placaMae->getLista();
        
$processador = new ProcessadorDAO();
$dadosProcessador = $processador->getLista();
$arrayIDProcessadorExcept = [];

$memoria = new MemoriaDAO();
$dadosMemoria = $memoria->getLista(); 
$arrayIDMemoriaExcept = [];

$discoRigido = new DiscoRigidoDAO();
$dadosDRigido = $discoRigido->getLista();
$arrayIDDiscoExcept = [];

$contador = 0;
$arrayComputador = [];
       
        foreach ($dadosPlacaMae as $itemPlacaMae){
                $arrayComputador[]['placa_mae'] = $itemPlacaMae->getIdPlacaMae();
                $processadorAtual = 'Não encontrado!';
                $memoriaAtual = 'Não encontrado!';
                $hdAtual = 'Não encontrado!';
                
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
                              echo $itemMemoria->getCapacidade() . " " . $selectMemoria->getCapacidade();
                            
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
                $arrayComputador[$contador]['placa_mae'] = $itemPlacaMae->getIdPlacaMae();
		        $arrayComputador[$contador]['processador'] = $processadorAtual;
                $arrayComputador[$contador]['memoria'] = $memoriaAtual;
            $contador++;
        }
        print_r($arrayComputador);
       
$this->view->attValue('lista',$arrayComputador);
		
		//print_r($arrayPlacaMae);


     
        
     
    }

    public function contato()
    {
        $this->view->setTitle('Contato');
        $this->view->startForm('contatoFim');
        $this->view->addTemplate('paginas/contato');
        $this->view->endForm();
    }

    public function contatoFim()
    {
        extract($_POST);
        $mensagem = "==============================================================================" . PHP_EOL;
        $mensagem.="NOME: " . $nome . PHP_EOL;
        $mensagem.="E_MAIL: " . $email . PHP_EOL;
        $mensagem.="==============================================================================" . PHP_EOL;
        $mensagem.="MENSAGEM:" . PHP_EOL;
        $mensagem.=$texto . PHP_EOL;
        $mensagem.="==============================================================================" . PHP_EOL;
        if (MailUtil::sendMail(MAIL_USER, "marcio.bigolinn@gmail.com", "[" . $assunto . "] Email de " . $nome, $mensagem)) {
            $this->view->setTitle('Sucesso ao enviar sua mensagem!');
            $this->view->addMensagemSucesso('Sua mensagem foi enviada com sucesso, em breve retornaremos.');
        } else {
            $this->view->setTitle('Ocorreu um erro ao enviar sua mensagem!');
            $this->view->addMensagemErro('Estamos passando por dificuldades técnicas tente novamente mais tarde.');
        }
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
