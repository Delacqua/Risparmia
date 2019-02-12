<?php

class AziendaFornitori extends Azienda {

    public $prezzoE;
    public $serviziE;
    public $fatturazioneE;
    public $consumoE;

    public function __construct($objDB,$objConsumo) {
       parent::__construct($objDB);
       $this->expandServizi();
       $this->expandFatturazione();
       $this->prezzoE = $this->setPrezzo($objConsumo);
    }


    private function expandServizi () {
    	$result = array();

    	foreach (self::$serviziValidi as $key => $value) {
    		if (in_array($value['serviziagg'],$this->serviziAgg())) {
    			array_push($result,$value['serviziagg']);
    		}
    	}

    	$this->serviziE = $result;
    }

    private function expandFatturazione () {
    	$result = array();

    	foreach (self::$fatturazioneValide as $key => $value) {
    		if (in_array($value['fatturazione'],$this->fatturazione())) {
    			array_push($result,$value['fatturazione']);
    		}
    	}

    	$this->fatturazioneE = $result;
    }

    private function setPrezzo($objConsumo) {
        
        $calcolaPrezzo = new Prezzo();
        $calcolaPrezzo->setConsumo($objConsumo->getConsumo());
        $calcolaPrezzo->setPrezzo($this->prezzo(),$objConsumo->getArrayConsumo());
        $calcolaPrezzo->setPotenza($objConsumo->getPotenza());
        $this->consumoE = $objConsumo->getConsumo();
        
            return $calcolaPrezzo->expandPrezzo();    //Aggiorna il prezzo
    }


}
