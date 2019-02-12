<?php

class AziendaGas {

	public $nome;
	protected $prezzo; // prezzo
	protected $prezzoMateria; // array prezzo (regione 1, 2, 3, 4, 5, 6)
	protected $transporto; // array transporto, stoccaggio
	protected $stoccaggio; // array transporto, stoccaggio
	protected $tasseFise; // array imposte (Tutte le tasse meno iva)
	protected $IVA; // percentuale espresso in 0.00
	protected $arrayRegione; // array delle regione coperte per la azienda
	protected $serviziAgg;
	protected $fatturazione;
	public $logo; //path to img 
	public $prodotto;

	protected static $serviziValidi = array();
    protected static $fatturazioneValide = array();


//--- Set e Get
    public function getPrezzo() {
		return $this->prezzo;
	}

	public function getPrezzoMateria() {
		return $this->prezzoMateria;
	}

	public function getTransporto() {
		return $this->transporto;
	}

	public function getStoccaggio() {
		return $this->stoccaggio;
	}

	public function getTasseFise() {
		return $this->tasseFise;
	}

	public function getIva() {
		return $this->IVA;
	}

	public function getRegione() {
		return $this->arrayRegione;
	}

	public function getServiziAgg() {
		return $this->serviziAgg;
	}

	public function getFatturazione() {
		return $this->fatturazione;
	}

	private function setTabelle () {
		$dataDB = new DatabaseGas();
		$this->IVA = $dataDB->prendeTabella(DB_AZIENDE_IVA);

        if (count(self::$serviziValidi)==0 || count(self::$serviziValidi)==0) {
            self::$serviziValidi = $dataDB->prendeTabella(DB_SERVIZI_AGG);
            self::$fatturazioneValide = $dataDB->prendeTabella(DB_FATTURAZIONE);
        }
    }


//---
	public function __construct($objDB) {

		$this->setTabelle();

		$this->nome = $objDB['nome'];
		$this->prezzo = $objDB['prezzo'];
		$this->prezzoMateria = AdattaString::uscitaArray($objDB['prezzoMateria']);
		$this->transporto = $objDB['transporto'];
		$this->stoccaggio = $objDB['stoccaggio'];
		$this->tasseFise = AdattaString::uscitaArray($objDB['tasseFise']);
		$this->arrayRegione = AdattaString::uscitaArray($objDB['regione']);
		$this->serviziAgg = AdattaString::uscitaArray($objDB['serviziAgg']);
		$this->fatturazione = AdattaString::uscitaArray($objDB['fatturazione']);
		$this->logo = $objDB['logo'];
		$this->prodotto = $objDB['prodotto'];
	}

}