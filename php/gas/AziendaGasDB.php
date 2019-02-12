<?php

class AziendaGasDB extends AziendaGas {
	
    public $prezzo;
    public $prezzoMateria;
    public $transporto; // array transporto, stoccaggio
    public $stoccaggio; // array transporto, stoccaggio
    public $tasseFise; // array imposte (Tutte le tasse meno iva)
    public $serviziAgg;
    public $fatturazione;
    public $serviziE;
    public $serviziR;
    public $fatturazioneE;
    public $fatturazioneR;
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
        $this->serviziR = array_values(array_diff(parent::getServiziAgg(),$arrayTotale));

    }

    private function expandFatturazione () {
        $arrayTotale = array();

        foreach (self::$fatturazioneValide as $key => $value) {
            array_push($arrayTotale,$value['fatturazione']);
        }

        $this->fatturazioneE = $arrayTotale;
        $this->fatturazioneR = array_values(array_diff(parent::getFatturazione(),$arrayTotale));
    }

    private function aggiustaData ($value) {
        $result = DateTime::createFromFormat('Y-m-d H:i:s', $value);
        $result = $result->format('d-m');
    
            return $result;
    }

}