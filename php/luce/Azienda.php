<?php

include_once 'urls.php';

class Azienda {

	public $nome;
	protected $prezzo; //array monoraria , f1 , f2, f3
	protected $energiaCotaFissa;
	protected $energiaPotenza;
	protected $energiaVariabile; //array d1, d2, d3, d4
	protected $transportoCotaFissa;
	protected $transportoVariabile; //array d1, d2, d3, d4
	protected $arrayRegione; // array delle regione coperte della azienda
	protected $serviziAgg;
	protected $fatturazione;
	protected $perequazione;
	public $logo; //path to img 
	public $prodotto;

	protected static $serviziValidi = array();
    protected static $fatturazioneValide = array();


//--- Set e Get
	public function serviziAgg() {
		return $this->serviziAgg;
	}

	public function fatturazione() {
		return $this->fatturazione;
	}

	public function prezzo() {
		return $this->prezzo;
	}

	public function energiaCotaFissa() {
		return $this->energiaCotaFissa;
	}

	public function transportoCotaFissa() {
		return $this->transportoCotaFissa;
	}

	public function transportoVariabile() {
		return $this->transportoVariabile;
	}

	public function energiaPotenza() {
		return $this->energiaPotenza;
	}

	public function energiaVariabile() {
		return $this->energiaVariabile;
	}

	public function getRegione() {
		return $this->arrayRegione;
	}

	private function setTabelle () {
        if (count(self::$serviziValidi)==0 || count(self::$serviziValidi)==0) {
            $dataDB = new DatabaseLuce();
            self::$serviziValidi = $dataDB->prendeTabella(DB_SERVIZI_AGG);
            self::$fatturazioneValide = $dataDB->prendeTabella(DB_FATTURAZIONE);
        }
    }


//---
	public function __construct($objDB) {

		$this->setTabelle();

		$this->nome = $objDB['nome'];
		$this->prezzo = array(floatval($objDB['prezzo']),floatval($objDB['f1']),floatval($objDB['f2']),floatval($objDB['f3']));
		$this->arrayRegione = AdattaString::uscitaArray($objDB['regione']);
		$this->serviziAgg = AdattaString::uscitaArray($objDB['serviziAgg']);
		$this->fatturazione = AdattaString::uscitaArray($objDB['fatturazione']);
		$this->f1 = $objDB['f1'];
		$this->f2 = $objDB['f2'];
		$this->f3 = $objDB['f3'];
		$this->logo = $objDB['logo'];
		$this->prodotto = $objDB['prodotto'];
		$this->energiaCotaFissa = floatval($objDB['energiaCotaFissa']);
		$this->transportoCotaFissa = floatval($objDB['transportoCotaFissa']);
		$this->transportoVariabile = AdattaString::uscitaArray($objDB['transportoVariabile']);
		$this->energiaVariabile = AdattaString::uscitaArray($objDB['energiaVariabile']);
		$this->energiaPotenza = floatval($objDB['energiaPotenza']);
		$this->perequazione = floatval($objDB['perequazione']);
	}

}