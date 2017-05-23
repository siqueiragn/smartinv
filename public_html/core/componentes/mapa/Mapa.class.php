<?php


/**
 * A classe Mapa permite que seja adicionado o componente mapa em uma página.
 * 
 * Essa classe carrega os componentes do OpenLayers para o controlador e depois
 * o Visualizador.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package componentes.mapa
 * @version 1.0.0 - 10/11/2013
 */
class Mapa extends Componente{
    
    private $proj4JS;
    private $idMapa;
    private $iniciado = 0;    
    private $zoom = 11;
    
    /**
     * 
     * @param String $idMaoa Id do componente HTML do mapa
     * @param Boolean $proJS Se irá usar a biblioteca proj4JS - Padrão não utilizar 
     */
    public function __construct($idMapa, $proj4JS = false){
        $this->proj4JS = $proj4JS;
        $this->idMapa = $idMapa;
        self::$i = 0;
        $this->requires();
    }
    
    public function add()
    {
        $this->adicionaComponente($this->view);
    }
    
    /**
     * 
     * @param \Visualizador $visualizador
     * @throws ProgramacaoErro
     */
    public function adicionaComponente(\AbstractView $visualizador) {
        if(self::$adicionado){
            throw new ProgramacaoException("Atualmente não é permitido adicionar mais de"
                    . " um mapa por página.");
        }
        self::$adicionado = true;
        
        $visualizador->addTemplate(CORE . 'view/templates/componentes/mapa/mapa');
        $visualizador->attValue('ID_MAPA', $this->idMapa);
        
        //$visualizador->addJquery();
        $visualizador->addLibCSS('componentes/mapa/mapa');
        $visualizador->CDN()->add('openlayers');
        $visualizador->CDN()->add('googlemaps');
        $visualizador->addLibJS('componentes/mapa/main');
        $visualizador->addSelfScript('idMapa = "' . $this->idMapa . '";', true);
        
        if($this->proj4JS){
            $visualizador->addLibJavaScript('componentes/maps/proj4js/proj4js-combined');
        }
    }
    
    /**
     * 
     * @throws ProgramacaoErro();
     */
    public function iniciarMapa(){
        if(self::$adicionado){
            self::$i++;
            $this->view->addSelfScript('var mapa' . self::$i . ' = new Mapa(idMapa);', true);
            $this->view->addSelfScript('var estatistica = new Object();', true);
            $this->view->addSelfScript('mapa' . self::$i . '.setBaseUrl("/mapServer");', true);
            $this->view->addSelfScript('mapa' . self::$i . '.x = -5700840;', true);
            $this->view->addSelfScript('mapa' . self::$i . '.y = -3512988;', true);

            $this->view->addSelfScript('mapa' . self::$i . '.zoom = ' . $this->zoom . ';', true);

            $this->view->addSelfScript('mapa' . self::$i . '.iniciaMapa();', true);            
            $this->iniciado = self::$i;
        }else{
            throw new ProgramacaoException('É necessário adicionar o componente antes de iniciar o mapa');
        }
    }
    
    public function addCamada(core\componentes\mapa\layers\Layer $layer){
        if($this->iniciado){
            $this->view->addSelfScript($layer, true);
        }else{
            $this->iniciarMapa();
        }
    }
    
    public function getZoom()
    {
        return $this->zoom;
    }

    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        return $this;
    }

        
    private function requires()
    {
        spl_autoload_register(function($classe)
        {
            $arquivo = __DIR__ . '/layers/' . $classe . '.class.php';
            if (file_exists($arquivo)) {
                require $arquivo;
                return ;
            }
            $arquivo = __DIR__ . '/legenda/' . $classe . '.class.php';
            if (file_exists($arquivo)) {
                require $arquivo;
                return ;
            }
        });
        

    }
    
    

}

