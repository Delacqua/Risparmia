<?php

class AziendaGasFornitori extends AziendaGas {

    public $prezzoE;
    public $serviziE;
    public $fatturazioneE;

    public function __construct($objDB,$objConsumo) {
       parent::__construct($objDB);
       $this->expandServizi();
       $this->expandFatturazione();
       $this->prezzoE = $this->setPrezzo($objConsumo);
    }


    private function expandServizi () {
    	$result = array();

    	foreach (self::$serviziValidi as $key => $value) {
    		if (in_array($value['serviziagg'],$this->getServiziAgg())) {
    			array_push($result,$value['serviziagg']);
    		}
    	}

    	$this->serviziE = $result;
    }

    private function expandFatturazione () {
    	$result = array();

    	foreach (self::$fatturazioneValide as $key => $value) {
    		if (in_array($value['fatturazione'],$this->getFatturazione())) {
    			array_push($result,$value['fatturazione']);
    		}
    	}

    	$this->fatturazioneE = $result;
    }

    private function setPrezzo($objConsumo) {
        
        $calcolaPrezzo = new PrezzoGas();
        $calcolaPrezzo->setConsumo($objConsumo->getConsumo());
        $calcolaPrezzo->setRegione($objConsumo->getRegione());
        $calcolaPrezzo->setPrezzoMateria($this->getPrezzo());
        $calcolaPrezzo->setTransporto($this->getTransporto(),$this->getStoccaggio());
        
            return $calcolaPrezzo->getPrezzoExpand();
    }


}
