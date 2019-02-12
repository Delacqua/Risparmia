<?php

class AziendaDB extends Azienda {
	
    public $serviziE;
    public $serviziR;
    public $fatturazioneE;
    public $fatturazioneR;
    public $prezzo;
    public $energiaCotaFissa;
    public $energiaPotenza;
    public $energiaVariabile; //array d1, d2, d3, d4
    public $transportoCotaFissa;
    public $transportoVariabile; //array d1, d2, d3, d4
    public $serviziAgg;
    public $fatturazione;
    public $perequazione;
    public $regione;
    public $id;
    public $dataIni; //data dell'ultima modifica


    public function __construct($objDB) {
       parent::__construct($objDB);
       $this->id = $objDB['id'];
       $this->dataIni = $this->aggiustaData($objDB['dataIni']);
       $this->expandServizi();
       $this->expandFatturazione();
       $this->regione = $this->getRegione();
    }


    private function expandServizi () {
        $arrayTotale = array();
        
        foreach (self::$serviziValidi as $key => $value) {
            array_push($arrayTotale,$value['serviziagg']);
        }

        $this->serviziE = $arrayTotale;
        $this->serviziR = array_values(array_diff(parent::serviziAgg(),$arrayTotale));

    }

    private function expandFatturazione () {
        $arrayTotale = array();

        foreach (self::$fatturazioneValide as $key => $value) {
            array_push($arrayTotale,$value['fatturazione']);
        }

        $this->fatturazioneE = $arrayTotale;
        $this->fatturazioneR = array_values(array_diff(parent::fatturazione(),$arrayTotale));
    }

    private function aggiustaData ($value) {
        $result = DateTime::createFromFormat('Y-m-d H:i:s', $value);
        $result = $result->format('d-m');
    
            return $result;
    }

}