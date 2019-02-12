<?php

//--------

include_once '..\php\urls.php';

//--------------

class Prezzo {

	private $consumo; //consumo totale annuale
	private $arrayScaglione; //consumo diviso per le fascie delle tasse
	private $arrayOrarie; //true = monorarie - consumo diviso per le fascie orarie f1, f2, f3 
	
	private $prezzo; // Prezzo Mono oppure array  f1, f2, f3 (array entrata mono, f1, f2 ...)
	
	private $energiaFisso; //valore mensile
	private $energiaVariabile;

	private $scaglioneFascia; // array
	
	private $transportoPrezzo; // array - tariffa di trasporto, stessa misura scaglioneFascia
	private $transportoFisso; //

	private $percentualeIVA; // percentuale espresso in 0.00
	private $IVA; //iva nominale del consumo attuale

	private $potenza; // Potenza impegnata
	private $potenzaPrezzo; // Potenza prezzo al mese

	private $oneri; //array con valore aggiunti perequazione , etc
	private $accisa;


	public function __construct() {
        $this->accisa = 0;
        $this->arrayScaglione = array ();
        $this->setTasse();
  	}


// ----- Set e get

  	public function setConsumo ($consumo) {
  		$this->consumo = $consumo;
  	}

	public function setPrezzo ($prezzo, $arrayOrarie) {
		/*
        if ($arrayOrarie) { $this->prezzo =  $prezzo[0]; }
        	else { $this->prezzo = array_splice($prezzo, 1); }
        */
        $this->prezzo =  $prezzo;
       	$this->arrayOrarie =  $arrayOrarie;
  	}

	public function setEnergia ($energiaFisso, $energiaVariabile) {
  		$this->energiaFisso =  $energiaFisso;
  		$this->energiaVariabile = $this->setEnergiaVariabile($energiaVariabile);
  	}

	public function setTransporto ($transportoFisso, $transportoPrezzo ) {
  		$this->transportoFisso =  $transportoFisso;
  		$this->transportoPrezzo = $transportoPrezzo;
  	}

  	public function setPotenza ($potenza, $potenzaPrezzo) {
  		$this->potenza =  $potenza;
  		$this->potenzaPrezzo =  $potenzaPrezzo;
  	}

  	public function setTasse () {
  		$dataDB = new DatabaseLuce();
  		$percentualeIVA = $dataDB->prendeTabella(DB_IVA);
  		$this->percentualeIVA = $percentualeIVA[0]['iva'];

  		$this->scaglioneFascia = $dataDB->prendeTabella(DB_ACCISA);
        $this->arrayScaglione = $this->divideScaglione();

        $oneri = $dataDB->prendeTabella(DB_ALTRE_TASSE);
  		$this->oneri =  $oneri;
  	}

  	public function setEnergiaVariabile ($arrayEnergia) {
  		$array = array();
  		$array = $arrayEnergia;

  		return $array;
  	}

	public function expandPrezzo () {
			return $this->prezzoSimplece();
	}



//-----------------------------	


//--- Costo Materia energia
	private function spesaMateria () {
		$soma = 0;

		if ($this->arrayOrarie) {
			$soma = ($this->energiaFisso * 12) + ($this->consumo * $this->prezzo);
			$partiale = $this->dispacciamento($this->energiaVariabile);
			$soma = $soma + $partiale;
			$this->accisa = $this->accisa + $partiale;
		}

			else {
				$soma = ($this->energiaFisso * 12) + $this->consumoOrario();
				$partiale = $this->dispacciamento($this->energiaVariabile);
				$soma = $soma + $partiale;
				$this->accisa = $this->accisa + $partiale;
			}

		return $soma;
	}

//--- Costo Transporto e gestione
	private function spesaTransporto () {
		$soma = 0;
		$soma = ($this->transportoFisso * 12) + ($this->potenza * $this->potenzaPrezzo * 12);
		$partiale = $this->dispacciamento($this->transportoPrezzo);
		$soma = $soma + $partiale;
		$this->accisa = $this->accisa + $partiale;

		return $soma;
	}

//oneri diversi	
	private function oneri () {
		$soma = 0;
		
		if (!is_null($this->oneri)) {

			foreach ($this->oneri as $value) {
				$soma = $soma + $value['valore'];
			}
		}

		return $soma;
	}

//iva
	private function aggiungeIva($totale) {
		$soma = $totale * $this->percentualeIVA;
		$this->IVA = $soma;
		return $soma;
	}


//-------------------


//-- Soma totale
	private function prezzoPieno () {
		$energia = (float) $this->spesaMateria();
		$transporto = (float) $this->spesaTransporto();
		$oneri = (float) $this->oneri();

		$partiale = $energia + $transporto + $oneri;
		$totale = $partiale + $this->aggiungeIva($partiale);

		$prezzoExpand = (object) ['energia' =>$energia, 'rede' => $transporto, 'imposte' => $this->accisa+$oneri, 'iva' => $this->IVA, 'prezzoT' => $totale];

			return $prezzoExpand;
	}

	private function prezzoSimplece () {
		$energia = (float) $this->spesaMateria2();
		$transporto = (float) $energia * 0.20;
		$oneri = (float) $energia + $transporto * 0.22;

		$partiale = $energia + $transporto + $oneri;
		$totale = $partiale + $this->aggiungeIva($partiale);

		$prezzoExpand = (object) ['energia' =>$energia, 'rede' => $transporto, 'imposte' => $this->accisa+$oneri, 'iva' => $this->IVA, 'prezzoT' => $totale];

			return $prezzoExpand;
	}


//Prezzo simplece 
	private function spesaMateria2 () {
		$energia = 0 ;

		if ($this->prezzo[0]>0) {
			$energia = $this->prezzo[0] * $this->consumo;
		}
		else {
			foreach ($this->arrayOrarie as $key => $value) {
				$energia += $value * $this->prezzo[$key+1];
			}
		}

		return $energia;
	}



//Imposte ------------- 
	private function dispacciamento($arrayPrezzo) {
		$soma = 0;

		foreach ($this->arrayScaglione as $key => $value) {
			$soma = $soma + ($value * $arrayPrezzo[$key]);
		}

		return $soma;
	}

	private function divideScaglione() {
       $arrayScaglione = DividereFascia::fasciaArray($this->consumo,$this->scaglioneFascia);
	       return $arrayScaglione;
	}

	private function consumoOrario() {
		$soma = 0;

        foreach($this->arrayOrarie as $key => $valore){
        	$soma = $soma + ($valore * $this->prezzo[$key]);
        }

       return $soma;
	}


}