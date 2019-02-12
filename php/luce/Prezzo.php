<?php

//--------

include_once '..\php\urls.php';

//--------------

class Prezzo {

	private $consumo; //consumo totale annuale
	private $arrayOrarie; //true = monorarie - consumo diviso per le fascie orarie f1, f2, f3 
	
	private $prezzo; // Prezzo Mono oppure array  f1, f2, f3 (array entrata mono, f1, f2 ...)
	
	private $energiaFisso;
	private $quotaEnergia;

	private $transportoFisso; //
	private $trasmissione;
	private $transportoPotenza;

	private $percentualeIVA; // percentuale espresso in 0.00

	private $potenza; // Potenza impegnata
	private $potenzaPrezzo; // Potenza prezzo al mese

	private $oneri; //array con valore aggiunti perequazione , etc
	private $dispacciamento;
	private $accisa;


	public function __construct() {
        $this->setTasse();
  	}


// ----- Set e get

  	public function setConsumo ($consumo) {
  		$this->consumo = $consumo;
  	}

	public function setPrezzo ($prezzo, $arrayOrarie) {
		$this->prezzo =  $prezzo;
       	$this->arrayOrarie =  $arrayOrarie;
  	}

/*
  	public function setPrezzo ($prezzo, $arrayOrarie) {
        if ($arrayOrarie) { $this->prezzo =  $prezzo[0]; }
        	else { $this->prezzo = array_splice($prezzo, 1); }
       	$this->arrayOrarie =  $arrayOrarie;
  	}
*/

  	public function setPotenza ($potenza) {
  		$this->potenza = $potenza;
  	}

  	public function setTasse () {
  		$dataDB = new DatabaseLuce();
  		$percentualeIVA = $dataDB->prendeTabella(DB_IVA);
  		$this->percentualeIVA = $percentualeIVA[0]['iva'];

  		$this->energiaFisso =  4.7353;
  		$this->potenzaPrezzo =  30.0735;
  		$this->quotaEnergia = 0.00062;

  		$this->transportoFisso =  18.96;
  		$this->trasmissione = 0.00719;
  		$this->transportoPotenza = 21.48;

  		$this->dispacciamento = 0.000687 + 0.001037 + 0.001411 + 0.000398;

  		$this->accisa = $dataDB->prendeTabella(DB_ACCISA);

        $oneri = $dataDB->prendeTabella(DB_ALTRE_TASSE);
  		$this->oneri =  $oneri;
  	}


	public function expandPrezzo () {
			return $this->prezzoPieno();
	}



//-----------------------------	


//--- Costo Materia energia
	private function spesaMateria () {
		$energiaFisso = $this->energiaFisso;
		$potenzaPrezzo = ($this->potenzaPrezzo * $this->potenza);
		$quotaEnergia = $this->quotaEnergia * $this->consumo;

		$materia = 0;

		if ($this->prezzo[0] > 0 ) {
			$materia =  $this->consumo * $this->prezzo[0];
		}

			else {
				$materia += $this->arrayOrarie[0] * $this->prezzo[1];
				$materia += $this->arrayOrarie[1] * $this->prezzo[2];
				$materia += $this->arrayOrarie[2] * $this->prezzo[3];
			}

		$soma = $materia + $energiaFisso + $potenzaPrezzo + $quotaEnergia;

			return $soma;
	}

//--- Costo Transporto e gestione
	private function spesaTransporto () {
		$soma = $this->transportoFisso;
		$soma += $this->trasmissione  * $this->consumo;
		$soma += $this->transportoPotenza * $this->potenza;

			return $soma;
	}

//oneri diversi	
	private function imposte () {
		$consumoMese = $this->consumo / 12;
		
		$imposte = 0;

		if ($this->potenza >= $this->accisa[0]['potenza']) {
			if ($this->accisa[0]['fascia'] < $consumoMese) {
				$temp = $consumoMese - $this->accisa[0]['fascia'];
				$imposte = $this->accisa[0]['valore'] * $temp;
			}
		}

			else {
				$imposte = $consumoMese * $this->accisa[0]['valore'];
			}


			return $imposte * 12;
	}


//oneri diversi	
	private function oneri () {
		$oneri = 0;

		$dispacciamento = $this->dispacciamento * $this->consumo;

		$fascia = DividereFascia::fasciaArray($this->consumo,$this->oneri);
		$a2 = 0;
		$a3 = 0;
		$a4 = 0;
		$a5 = 0;
		$as = 0;
		$ae = 0;
		$uc3 = 0;
		$uc4 = 0;
		$uc6a = $this->oneri[0]['oneriuc6a'] * $this->potenza;
		$uc6m = 0;
		$uc7 = 0;
		$mct = 0;

		foreach ($fascia as $key => $value) {
			$a2 += $this->oneri[$key]['oneria2'] * $value;
			$a3 += $this->oneri[$key]['oneria3'] * $value;
			$a4 += $this->oneri[$key]['oneria4'] * $value;
			$a5 += $this->oneri[$key]['oneria5'] * $value;
			$as += $this->oneri[$key]['onerias'] * $value;
			$ae += $this->oneri[$key]['oneriae'] * $value;
			$uc3 += $this->oneri[$key]['oneriuc3'] * $value;
			$uc4 += $this->oneri[$key]['oneriuc4'] * $value;
			$uc6m += $this->oneri[$key]['oneriuc6m'] * $value;
			$uc7 += $this->oneri[$key]['oneriuc7'] * $value;
			$mct += $this->oneri[$key]['onerimct'] * $value;
		}


		$oneri = $a2 + $a3 + $a4 + $a5 + $as + $ae + $uc3 + $uc4 + $uc6a + $uc6m + $uc7 + $mct;

		$oneri += $dispacciamento;

			return $oneri;
	}

//iva
	private function aggiungeIva($totale) {
		$soma = $totale * $this->percentualeIVA;

			return $soma;
	}


//-------------------


//-- Soma totale
	private function prezzoPieno () {
		$energia = (float) $this->spesaMateria();
		$transporto = (float) $this->spesaTransporto();
		$imposte = (float) $this->imposte();
		$oneri = (float) $this->oneri();

		$partiale = $energia + $transporto + $oneri + $imposte;
		$iva = $this->aggiungeIva($partiale);
		$totale = $partiale + $iva;

		$prezzoExpand = (object) ['energia' =>$energia, 'rede' => $transporto, 'imposte' => $imposte + $oneri, 'iva' => $iva, 'prezzoT' => $totale];

			return $prezzoExpand;
	}

}